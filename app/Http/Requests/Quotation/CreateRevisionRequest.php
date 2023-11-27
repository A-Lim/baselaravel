<?php

namespace App\Http\Requests\Quotation;

use App\Http\Requests\CustomFormRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Client;

class CreateRevisionRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'store_id' => 'required|exists:stores,id',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'required_without:client_id|string',
            'client_ssm_no' => 'required_without:client_id|string',
            'client_phone' => 'required_without:client_id|string',
            'client_email' => 'required_without:client_id|email',
            'client_address' => 'required_without:client_id|string',
            'client_type' => 'required_without:client_id|string|in:'.implode(',', Client::TYPES),
            'type' => 'required|string|in:'.implode(',', Quotation::TYPES),
            'name' => 'required|string',
            'cost' => 'nullable|decimal:0,2',
            'costing_details' => 'nullable|string',
            'total' => 'required|decimal:0,2',
            'remark' => 'nullable|string',

            'quotation_items' => 'required|array',
            'quotation_items.*.sequence' => 'required|integer',
            'quotation_items.*.quantity' => 'required|integer',
            'quotation_items.*.unit' => 'required|string|in:'.implode(',', QuotationItem::TYPES),
            'quotation_items.*.total' => 'required|decimal:0,2',
            'quotation_items.*.description' => 'required|string',
        ];
    }

    public function messages() {
        return [
            'cost.decimal' => 'The :attribute must be 0 to 2 decimal places',
            'total.decimal' => 'The :attribute must be 0 to 2 decimal places',
            'quotation_items.*.total' => 'The quotation item total must be 0 to 2 decimal places',
        ];
    }
}
