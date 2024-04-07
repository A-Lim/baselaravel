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

    public function packages(Customer $customer, $data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = CustomerPackage::buildQuery($data)
            ->join('packages', 'packages.id', '=', 'customer_package.package_id')
            ->select('customer_package.*', 'packages.name')
            ->where('customer_package.customer_id', $customer->id)
            ->orderBy('count', 'desc')
            ->orderBy('purchased_date', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function purchasePackage(Customer $customer, $data) {
        $customer->packages()->attach($data['package_id'], [
            'count' => $data['count'],
            'price' => $data['price'],
            'remarks' => @$data['remarks'],
            'purchased_date' => $data['purchased_date'] ?? Carbon::now(),
            'created_by' => auth()->id(),
        ]);
    }

    public function bulkPurchasePackage(Customer $customer, $data) {
        Db::beginTransaction();
            $payments = [];
            foreach ($data as $row) {
                $row['customer_id'] = $customer->id;
                $row['created_by'] = auth()->id();
                $row['purchased_date'] = Carbon::now();

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
