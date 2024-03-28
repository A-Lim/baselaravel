<?php

namespace App\Http\Requests\Package;

use App\Http\Requests\CustomFormRequest;

class BulkCreateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            '*.name' => 'required|string',
            '*.default_count' => 'required|integer',
            '*.default_price' => 'required|numeric',
            '*.description' => 'nullable|string',
        ];
    }
}
