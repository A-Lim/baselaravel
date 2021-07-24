<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\CustomFormRequest;
use App\Models\Device;

class UpdateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'type' => 'required|string|in:'.implode(',', Device::TYPES),
            'token' => 'required|string|unique:devices,token',
            'uuid' => 'required|string',
        ];
    }
}
