<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\CustomFormRequest;

class UpdatePackageRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'count' => 'required|integer',
            'price' => 'required|numeric',
            'remarks' => 'nullable|string',
        ];
    }
}
