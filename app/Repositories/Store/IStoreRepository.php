<?php
namespace App\Repositories\Store;

use App\Models\Store;

interface IStoreRepository {

    public function list($data, $paginate = false);

    public function create(array $data);

    public function update(Store $store, array $data);
}
