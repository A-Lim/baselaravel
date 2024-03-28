<?php
namespace App\Repositories\Customer;

use App\Models\Customer;
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
}
