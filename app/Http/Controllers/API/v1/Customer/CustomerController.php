<?php

namespace App\Http\Controllers\API\v1\Customer;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\PurchaseRequest;
use App\Http\Requests\Customer\BulkPurchaseRequest;
use App\Http\Requests\Customer\BulkCreateRequest;
use App\Repositories\Customer\ICustomerRepository;
use App\Repositories\Transaction\ITransactionRepository;
use App\Http\Resources\Customers\CustomerPackageCollection;
use App\Http\Resources\Transactions\TransactionCollection;

class CustomerController extends ApiController
{
    private $customerRepository;
    private $transactionRepository;

    public function __construct(ICustomerRepository $iCustomerRepository,
        ITransactionRepository $ITransactionRepository) {
        $this->middleware('auth:api');
        $this->customerRepository = $iCustomerRepository;
        $this->transactionRepository = $ITransactionRepository;
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

    public function packages(Request $request, Customer $customer) {
        $this->authorize('view', $customer);
        $customerPackages = $this->customerRepository->packages($customer, $request->all(), true);
        $collection = new CustomerPackageCollection($customerPackages);
        return $this->responseWithData(200, $collection);
    }

    public function packagesWithBalance(Request $request, Customer $customer) {
        $this->authorize('view', $customer);
        $packages = $this->customerRepository->packagesWithBalance($customer, $request->all());
        // $collection = new CustomerPackageCollection($customers);
        return $this->responseWithData(200, $packages);
    }

    public function purchasePackage(PurchaseRequest $request, Customer $customer) {
        $this->authorize('update', $customer);
        $this->customerRepository->purchasePackage($customer, $request->all());
        return $this->responseWithMessage(201, 'Package(s) added');
    }

    public function bulkPurchasePackage(BulkPurchaseRequest $request, Customer $customer) {
        $this->authorize('update', $customer);
        $this->customerRepository->bulkPurchasePackage($customer, $request->all());
        return $this->responseWithMessage(201, 'Package added');
    }

    public function transactions(Request $request, Customer $customer) {
        $this->authorize('view', $customer);
        
        $data = $request->all();
        $data['customer_id'] = $customer->id;
        $transactions = $this->transactionRepository->list($data, true);

        $collection = new TransactionCollection($transactions);
        return $this->responseWithData(200, $collection);
    }
}
