<?php

namespace App\Http\Resources\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCustomerPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'customerpackage_id' => $this->id,
            'name' => $this->name,
            'amount' => (float) $this->pivot->amount,
        ];
    }
}
