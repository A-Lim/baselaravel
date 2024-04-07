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
        // dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount_paid' => (float) $this->pivot->amount,
        ];
    }
}
