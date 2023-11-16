<?php

namespace App\Http\Controllers\API\v1\Store;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Store\CreateRequest;
use App\Http\Requests\Store\UpdateRequest;
use App\Repositories\Store\IStoreRepository;

class StoreController extends ApiController {

    private $storeRepository;

    public function __construct(IStoreRepository $iStoreRepository) {
        $this->middleware('auth:api');
        $this->storeRepository = $iStoreRepository;
    }

    public function list(Request $request) {
        $this->authorize('viewAny', Store::class);
        $stores = $this->storeRepository->list($request->all());
        return $this->responseWithData(200, $stores);
    }

    public function create(CreateRequest $request, Store $store) {
        $this->authorize('create', Store::class);
        $this->storeRepository->create($request->all());
        return $this->responseWithMessage(200, 'Store created.');
    }

    public function update(UpdateRequest $request, Store $store) {
        $this->authorize('update', Store::class);
        $this->storeRepository->update($store, $request->all());
        return $this->responseWithMessage(200, 'Store updated.');
    }
}
