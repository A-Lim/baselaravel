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
        return $user->can('dashboards.view') && 
            ($user->status == 'active' || 
            $user->status == 'inactive');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function view(User $user, Dashboard $model) {
        return $user->can('dashboards.view') && 
            ($user->status == 'active' || 
            $user->status == 'inactive');;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->can('dashboards.create') && $user->status == 'active';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function update(User $user, Dashboard $model) {
        return $user->can('dashboards.update') && 
            ($model->public || $model->created_by == $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Dashboard $model
     * @return mixed
     */
    public function delete(User $user, Dashboard $model) {
        return $user->can('dashboards.delete') && 
            ($model->public || $model->created_by == $user->id);
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
