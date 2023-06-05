<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\CustomFormRequest;
use App\Models\Device;

class FbLoginRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
        // set message
        $this->setMessage('Invalid fb login token.');
    }

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'authToken' => 'required|string',
            'uuid' => 'nullable|string',
        ];
    }
}
