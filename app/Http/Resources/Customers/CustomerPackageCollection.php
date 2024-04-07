<?php

namespace App\Http\Resources\Customers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerPackageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = $this->resource->toArray();
        $result['data'] = $this->collection;
        return $result;
    }
}
