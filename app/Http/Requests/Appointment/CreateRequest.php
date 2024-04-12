<?php

namespace App\Http\Requests\Appointment;

use App\Models\CustomerPackage;
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
            'customer_id' => 'required|exists:customers,id',
            'remarks' => 'nullable|string',
            'customerpackage_ids' => 'required|array',
            'customerpackage_ids.*' => 'integer',
            'created_at' => 'nullable', //|date_format:Y-m-d\TH:i:s.u\Z'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $input = $this->input();
            $ids = $input['customerpackage_ids'];

            $count = CustomerPackage::where('customer_id', $input['customer_id'])
                ->whereIn('id', $ids)
                ->count();
            
            if ($count != count($ids)) {
                $validator->errors()
                    ->add('customerpackages.*.id', 'One or more of the listed package does not belong to this customer.');
            }
        });
    }
}
