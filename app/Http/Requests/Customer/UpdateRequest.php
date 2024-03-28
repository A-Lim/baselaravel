<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\CustomFormRequest;

class UpdateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'remarks' => 'nullable|string',
        ];
    }
}
