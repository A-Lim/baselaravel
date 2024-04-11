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
            'package_id' => $this->package_id,
            'name' => $this->name,
            'price' => $this->price,
            'count' => $this->count,
            'remarks' => $this->remarks,
            'status' => $this->status,
            'purchased_at' => $this->purchased_at,
        ];
    }
}
