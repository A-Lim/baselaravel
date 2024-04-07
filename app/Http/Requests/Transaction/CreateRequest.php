<?php

namespace App\Http\Requests\Transaction;

use App\Http\Requests\CustomFormRequest;
use App\Models\CustomerPackage;

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
            'customerpackages' => 'required|array',
            'customerpackages.*.id' => 'integer',
            'customerpackages.*.amount' => 'numeric',
            'created_at' => 'nullable', //|date_format:Y-m-d\TH:i:s.u\Z'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $input = $this->input();
            $ids = [];
            foreach ($input['customerpackages'] as $customerPackage) {
                array_push($ids, $customerPackage['id']);
            }

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
