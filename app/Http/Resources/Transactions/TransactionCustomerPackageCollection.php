<?php

namespace App\Http\Resources\Transactions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCustomerPackageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return TransactionCustomerPackageResource::collection($this->collection);
    }
}
