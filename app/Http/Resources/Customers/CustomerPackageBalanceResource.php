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
            'customerpackage_id' => $this->customerpackage_id,
            'name' => $this->name,
            'balance' => (float) $this->balance,
        ];
    }
}
