<?php
namespace App\Repositories\Customer;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\Transaction;
use Carbon\Carbon;

class CustomerRepository implements ICustomerRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Customer::buildQuery($data)
            ->orderBy('id', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function find($id) {
        return Customer::find($id);
    }

    public function create($data) {
        $data['created_by'] = auth()->id();
        return Customer::create($data);
    }

    public function createBulk($data) {
        $bulkInsert = [];
        $now = Carbon::now();
        $authorId = auth()->id();

        foreach ($data as $row) {
            array_push($bulkInsert, [
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'remarks' => $row['remarks'],
                'created_at' => $now,
                'updated_at' => $now,
                'created_by' => $authorId,
            ]);
        }
        
        Customer::insert($bulkInsert);
    }

    public function update(Customer $customer, $data) {
        $data['updated_by'] = auth()->id();
        $customer->fill($data);
        $customer->save();

        return $customer;
    }

    public function delete(Customer $customer) {
        $customer->delete();
    }

    public function updatePackage(CustomerPackage $customerPackage, $data) {
        $data['updated_by'] = auth()->id();
        $customerPackage->fill($data);
        $customerPackage->save();

        return $customerPackage;
    }

    public function deletePackage(CustomerPackage $customerPackage) {
        DB::beginTransaction();
            $transaction = Transaction::with('packages')
                ->whereHas('packages', function ($query) use ($customerPackage) {
                    $query->where('customerpackage_id', $customerPackage->id);
                })->first();
            
            $customerPackage->delete();

            if (count($transaction->packages) - 1 == 0) {
                $transaction->delete();
            }
        DB::commit();
    }

    public function packages(Customer $customer, $data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = CustomerPackage::buildQuery($data)
            ->join('packages', 'packages.id', '=', 'customer_package.package_id')
            ->select('customer_package.*', 'packages.name')
            ->where('customer_package.customer_id', $customer->id)
            ->orderByRaw('FIELD(status, \'active\', \'completed\', \'\') asc')
            ->orderBy('customer_package.purchased_at', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function packagesWithBalance(Customer $customer, $data) {
        $query = CustomerPackage::select('customer_package.id as customerpackage_id', 'packages.name', 
                DB::raw('(customer_package.price - IFNULL(SUM(customerpackage_transaction.amount), 0)) as balance'))
            ->leftjoin('customerpackage_transaction', 'customerpackage_transaction.customerpackage_id', '=', 'customer_package.id')
            ->join('packages', 'packages.id', '=', 'customer_package.package_id')
            ->where('customer_package.customer_id', $customer->id)
            ->groupBy('customer_package.id')
            ->orderBy('customer_package.purchased_at', 'desc');

        if (isset($data['has_balance'])) {
            $condition = intval($data['has_balance']) == 1
                ? 'balance > 0'
                : 'balance = 0';

            $query->havingRaw($condition);
        }

        return $query->get();
    }

    public function purchasePackage(Customer $customer, $data) {
        $customer->packages()->attach($data['package_id'], [
            'count' => $data['count'],
            'price' => $data['price'],
            'remarks' => @$data['remarks'],
            'status' => CustomerPackage::STATUS_ACTIVE,
            'purchased_at' => $data['purchased_at'] ?? Carbon::now(),
            'created_by' => auth()->id(),
        ]);
    }

    public function bulkPurchasePackage(Customer $customer, $data) {
        Db::beginTransaction();
            $payments = [];
            foreach ($data as $row) {
                $row['customer_id'] = $customer->id;
                $row['created_by'] = auth()->id();
                $row['purchased_at'] = Carbon::now();
                $row['status'] = CustomerPackage::STATUS_ACTIVE;

                $customerPackage = CustomerPackage::create($row);
                if (@$row['amount_paid']) {
                    array_push($payments, [
                        'customerpackage_id' => $customerPackage->id,
                        'amount' => $row['amount_paid']
                    ]);
                }
            }

            if (count($payments) > 0) {
                $transaction = Transaction::create([
                    'remarks' => 'Initial Deposit',
                    'customer_id' => $customer->id,
                    'created_by' => auth()->id(),
                ]);

                $transaction->packages()
                    ->sync($payments);
            }
        Db::commit();
    }
}
