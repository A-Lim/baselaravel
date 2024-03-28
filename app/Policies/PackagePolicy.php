<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy {
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
     * Determine whether the user can view any packages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->hasPermission('package.viewAny');
    }

    /**
     * Determine whether the user can view the package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Package  $package
     * @return mixed
     */
    public function view(User $user, Package $package) {
        return $user->hasPermission('package.view');
    }

    /**
     * Determine whether the user can create packages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('package.create');
    }

    /**
     * Determine whether the user can update the package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Package  $package
     * @return mixed
     */
    public function update(User $user, Package $package) {
        return $user->hasPermission('package.update');
    }

    /**
     * Determine whether the user can delete the package.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Package  $package
     * @return mixed
     */
    public function delete(User $user, Package $package) {
        return $user->hasPermission('package.delete');
    }
}
