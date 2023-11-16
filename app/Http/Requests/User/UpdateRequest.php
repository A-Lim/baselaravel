<?php

namespace App\Http\Requests\User;

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
            'gender' => 'nullable|string',
            'phone' => 'nullable',
            'date_of_birth' => 'nullable|date|date_format:Y-m-d',
            'store_ids' => 'nullable|array'
        ];
    }
}
