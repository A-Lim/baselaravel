<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\CustomFormRequest;

class BulkPurchaseRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            '*.package_id' => 'required|exists:packages,id',
            '*.count' => 'required|integer',
            '*.price' => 'required|numeric',
            '*.amount_paid' => 'nullable',
            '*.remarks' => 'nullable|string'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if (count($this->input()) == 0) {
                $validator->errors()
                    ->add('*', 'There should be at least one package');
            }
        });
    }
}
