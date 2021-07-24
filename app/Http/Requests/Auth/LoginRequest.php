<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\CustomFormRequest;
use App\Models\Device;

class LoginRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
        // set message
        $this->setMessage('Invalid login credentials.');
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'uuid' => 'nullable|string',
            'token' => 'nullable|string|required_with:uuid',
            'type' => 'nullable|string|required_with:uuid|in:'.implode(',', Device::TYPES)
        ];
    }
}
