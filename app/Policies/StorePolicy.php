<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy {
    use HandlesAuthorization;

    /**
     * Bypass any policy
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function before(User $user, $ability) {
        if ($user->isAdmin())
            return true;
    }

    /**
     * Determine whether the user can view any stores.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->hasPermission('stores.viewAny');
    }

    /**
     * Determine whether the user can view the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $store
     * @return mixed
     */
    public function view(User $user, Store $store) {
        return $user->hasPermission('stores.view');
    }

    /**
     * Determine whether the user can create stores.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('stores.create');
    }

    /**
     * Determine whether the user can update the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $store
     * @return mixed
     */
    public function update(User $user, Store $store) {
        return $user->hasPermission('stores.update');
    }

    /**
     * Determine whether the user can delete the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $store
     * @return mixed
     */
    public function delete(User $user, Store $store) {
        return $user->hasPermission('stores.delete');
    }

    /**
     * Determine whether the user can restore the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $store
     * @return mixed
     */
    public function restore(User $user, Store $store) {
        //
    }

    /**
     * Determine whether the user can permanently delete the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Store  $store
     * @return mixed
     */
    public function forceDelete(User $user, Store $store) {
        //
    }
}
