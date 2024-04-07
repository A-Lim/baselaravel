<?php

namespace App\Http\Resources\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Transactions\TransactionCustomerPackageResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'remarks' => $this->remarks,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'packages' => TransactionCustomerPackageResource::collection($this->packages),
        ];
    }
}
