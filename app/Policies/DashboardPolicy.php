<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Dashboard;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardPolicy {
    use HandlesAuthorization;

    /**
     * Bypass any policy
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function before(User $user, $ability) {
        if ($user->isAdmin())
            return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->hasPermission('dashboards.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function view(User $user, Dashboard $model) {
        return $user->hasPermission('dashboards.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('dashboards.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function update(User $user, Dashboard $model) {
        return $user->hasPermission('dashboards.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function delete(User $user, Dashboard $model) {
        return $user->hasPermission('dashboards.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function restore(User $user, Dashboard $model) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function forceDelete(User $user, Dashboard $model) {
        //
    }
}
