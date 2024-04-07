<?php

namespace App\Http\Resources\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPackageResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'price' => $this->price,
            'count' => $this->count,
            'remarks' => $this->remarks,
            'purchased_date' => $this->purchased_date,
        ];
    }
}
