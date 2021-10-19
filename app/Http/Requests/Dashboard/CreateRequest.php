<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\CustomFormRequest;

use App\Models\Dashboard;

class CreateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    protected function prepareForValidation()   {
        $this->merge([
            'public' => filter_var($this->public, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'uuid' => 'required|unique:dashboards,uuid',
            'public' => 'required|boolean',
        ];
    }
}
