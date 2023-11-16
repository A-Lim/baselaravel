<?php

namespace App\Http\Requests\Store;

use App\Http\Requests\CustomFormRequest;

class CreateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|unique:stores,name,NULL,id,deleted_at,NULL',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'quotation_terms' => 'nullable|string',
            'quotation_agreement' => 'nullable|string',
            'invoice_terms' => 'nullable|string'
        ];
    }
}
