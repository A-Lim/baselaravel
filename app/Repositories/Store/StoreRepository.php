<?php
namespace App\Repositories\Store;

use App\Models\Store;

class StoreRepository implements IStoreRepository {

    public function list($data, $paginate = false) {
        $limit = isset($data['limit']) ? $data['limit'] : 10;

        $query = Store::buildQuery($data)
            ->orderBy('id', 'desc');

        if ($paginate)
            return $query->paginate($limit);

        return $query->get();
    }

    public function create($data) {
        return Store::create($data);
    }
    
    public function update(Store $store, $data) {
        $store->fill($data);
        $store->save();

        return $store;
    }
}