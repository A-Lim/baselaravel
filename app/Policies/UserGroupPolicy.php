<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserGroupPolicy {
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
     * Determine whether the user can view any user groups.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->hasPermission('usergroups.viewAny');
    }

    /**
     * Determine whether the user can view the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return mixed
     */
    public function view(User $user, UserGroup $userGroup) {
        return $user->hasPermission('usergroups.view');
    }

    /**
     * Determine whether the user can create user groups.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('usergroups.create');
    }

    /**
     * Determine whether the user can update the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return mixed
     */
    public function update(User $user, UserGroup $userGroup) {
        return $user->hasPermission('usergroups.update');
    }

    /**
     * Determine whether the user can delete the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return mixed
     */
    public function delete(User $user, UserGroup $userGroup) {
        return $user->hasPermission('usergroups.delete');
    }

    /**
     * Determine whether the user can restore the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return mixed
     */
    public function restore(User $user, UserGroup $userGroup) {
        //
    }

    /**
     * Determine whether the user can permanently delete the user group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserGroup  $userGroup
     * @return mixed
     */
    public function forceDelete(User $user, UserGroup $userGroup) {
        //
    }
}
