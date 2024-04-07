<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\CustomFormRequest;

class PurchaseRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'package_id' => 'required|exists:packages,id',
            'count' => 'required|integer',
            'price' => 'required|numeric',
            'purchased_date' => 'nullable',
            'remarks' => 'nullable|string'
        ];
    }
}
