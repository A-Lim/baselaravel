<?php
namespace App\Repositories\Transaction;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository implements ITransactionRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Transaction::buildQuery($data)
            ->join('customers', 'customers.id', '=', 'transactions.customer_id')
            ->with(['packages' => function($query) {
                $query->join('packages', 'packages.id', '=', 'customer_package.package_id')
                    ->select('packages.name', 'customer_package.*');
            }])
            ->select('customers.name as customer_name', 'transactions.*')
            ->orderBy('id', 'desc');

        if ($data['customer_id']) {
            $query->where('transactions.customer_id', $data['customer_id']);
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
}
