<?php

namespace App\Http\Requests\File;

use App\Http\Requests\CustomFormRequest;

class UploadRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
          'files.*' => 'required|file',
          'folder' => 'nullable|string'
        ];
    }
}
