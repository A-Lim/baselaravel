<?php

namespace App\Http\Controllers\API\v1\Customer;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\BulkCreateRequest;
use App\Repositories\Customer\ICustomerRepository;

class CustomerController extends ApiController
{
    private $customerRepository;

    public function __construct(ICustomerRepository $iCustomerRepository) {
        $this->middleware('auth:api');
        $this->customerRepository = $iCustomerRepository;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Customer::class);

        $customers = $this->customerRepository->list($request->all(), true);
        return $this->responseWithData(200, $customers);
    }

    public function details(Customer $customer) {
        $this->authorize('view', $customer);
        return $this->responseWithData(200, $customer);
    }

    public function create(CreateRequest $request) {
        $this->authorize('create', Customer::class);
        $customer = $this->customerRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $customer, 'Customer created.');
    }

    public function bulkCreate(BulkCreateRequest $request) {
        $this->authorize('create', Customer::class);
        $this->customerRepository->createBulk($request->all());
        return $this->responseWithMessage(201, 'Customers created.');
    }

    public function update(UpdateRequest $request, Customer $customer) {
        $this->authorize('update', $customer);
        $customer = $this->customerRepository->update($customer, $request->all());
        return $this->responseWithMessageAndData(200, $customer, 'Customer updated.');
    }

    public function delete(Customer $customer) {
        $this->authorize('delete', $customer);
        $this->customerRepository->delete($customer);
        return $this->responseWithMessage(200, 'Customer deleted.');
    }
}
