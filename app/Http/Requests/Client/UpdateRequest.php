<?php

namespace App\Http\Requests\Client;

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
            'name' => 'required',
            'ssm_no' => 'required|unique:clients,ssm_no,'.$this->client->id,
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string'
        ];
    }
}