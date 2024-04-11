<?php

namespace App\Http\Controllers\API\v1\Customer;

use Illuminate\Http\Request;
use App\Models\CustomerPackage;
use App\Http\Requests\Customer\UpdatePackageRequest;
use App\Http\Controllers\ApiController;
use App\Repositories\Customer\ICustomerRepository;

class CustomerPackageController extends ApiController
{
    private $customerRepository;

    public function __construct(ICustomerRepository $iCustomerRepository) {
        $this->middleware('auth:api');
        $this->customerRepository = $iCustomerRepository;
    }

    public function update(UpdatePackageRequest $request, CustomerPackage $customerPackage) {
        $customerPackage = $this->customerRepository->updatePackage($customerPackage, $request->all());
        return $this->responseWithMessageAndData(200, $customerPackage, 'Customer\'s package updated.');
    }

    public function delete(Request $request, CustomerPackage $customerPackage) {
        $this->customerRepository->deletePackage($customerPackage);
        return $this->responseWithMessage(200, 'Customer\'s package deleted.');
    }
}
