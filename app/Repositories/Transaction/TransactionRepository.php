<?php
namespace App\Repositories\Transaction;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository implements ITransactionRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Transaction::join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->with(['packages' => function($query) use ($data) {
                $query->join('packages', 'packages.id', '=', 'customer_package.package_id')
                    ->select('packages.name', 'customer_package.*');

                if (@$data['customerPackage_id']) {
                    $query->where('customerpackage_transaction.customerpackage_id', $data['customerPackage_id']);
                }
            }])
            ->select('customers.name as customer_name', 'transactions.*')
            ->orderBy('id', 'desc');

        if (isset($data['customer_id'])) {
            $query->where('transactions.customer_id', $data['customer_id']);
        }

        if (isset($data['created_at'])) {
            $filterData = explode(':', $data['created_at']);
            $created_at = null;
            // ie: created_at=equals:2022-11-01 00:00:00
            if ($filterData > 2) {
                array_shift($filterData);
                $created_at = Carbon::parse(implode(':', $filterData));
            } else {
                $created_at = Carbon::parse($filterData[1]);
            }
            $query->whereDate('transactions.created_at', $created_at);
        }

        if (@$data['customerPackage_id']) {
            $query ->join('customerpackage_transaction', 'customerpackage_transaction.transaction_id', '=', 'transactions.id')
                ->where('customerpackage_transaction.customerpackage_id', $data['customerPackage_id']);
        }

        if ($paginate)
            return $query->paginate($limit);

        
        return $query->get();
    }

    public function create($data) {
        $data['created_at'] = @$data['created_at'] 
            ? Carbon::parse($data['created_at'])
            : Carbon::now();
        $data['created_by'] = auth()->id();

        $pivot = [];
        foreach ($data['customerpackages'] as $customer_package) {
            $pivot[$customer_package['id']] = ['amount' => $customer_package['amount']];
        }

        DB::beginTransaction();
            $transaction = Transaction::create($data);
            $transaction->packages()
                ->sync($pivot);
        DB::commit();
        
        return $transaction;
    }

    public function update(Transaction $transaction, $data) {
        $data['updated_by'] = auth()->id();

        $pivot = [];
        foreach ($data['customerpackages'] as $customer_package) {
            $pivot[$customer_package['id']] = ['amount' => $customer_package['amount']];
        }

        DB::beginTransaction();
            $transaction->fill($data);
            $transaction->save();
            $transaction->packages()
                ->sync($pivot);
        DB::commit();
        
        return $transaction;
    }

    public function delete(Transaction $transaction) {
        $transaction->delete();
    }
}
