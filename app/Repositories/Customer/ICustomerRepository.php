<?php
namespace App\Repositories\Customer;

use App\Models\Customer;

interface ICustomerRepository {

    public function list($data, $paginate = false);

    public function create($data);

    public function update(Customer $customer, $data);

    public function find($id);

    public function delete(Customer $customer);
}