<?php
namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Models\CustomerPackage;

interface ICustomerRepository {

    public function list($data, $paginate = false);

    public function find($id);

    public function create($data);

    public function createBulk($data);

    public function update(Customer $customer, $data);

    public function delete(Customer $customer);

    public function updatePackage(CustomerPackage $customerPackage, $data);

    public function deletePackage(CustomerPackage $customerPackage);

    public function packages(Customer $customer, $data, $paginate = false);

    public function packagesWithBalance(Customer $customer, $data);

    public function purchasePackage(Customer $customer, $data);

    public function bulkPurchasePackage(Customer $customer, $data);
}