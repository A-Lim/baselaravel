<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdateProfileRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'phone' => 'nullable',
            'gender' => 'required|string',
            'date_of_birth' => 'nullable|date_format:Y-m-d\TH:i:s.v\Z',
            'oldPassword' => 'nullable|string',
            'newPassword' => 'required_with:oldPassword|confirmed',
        ];
    }

    public function messages() {
        return [
            'newPassword.required_with' => 'New password is required.',
        ];
    }
}
