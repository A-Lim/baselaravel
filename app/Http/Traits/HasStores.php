<?php
namespace App\Http\Traits;

use App\Models\Store;

trait HasStores {
    public function stores() {
        return $this->belongsToMany(Store::class, 'store_user', 'store_id', 'user_id')
            ->where('stores.deleted_at', null);
    }

    public function allStores() {
        return Store::where('deleted_at', null)->get();
    }

    public function assignStores($store_ids) {
        if (in_array('all', $store_ids)) {
            $all_store_ids = Store::select('id')->get()->pluck('id');
            return $this->stores()->sync($all_store_ids);
        } else {
            return $this->stores()->sync($store_ids);
        }
    }
}
