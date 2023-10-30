<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy {
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
        return $user->hasPermission('announcements.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Announcement $model
     * @return mixed
     */
    public function view(User $user, Announcement $model) {
        return $user->hasPermission('announcements.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('announcements.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Announcement $model
     * @return mixed
     */
    public function update(User $user, Announcement $model) {
        return $user->hasPermission('announcements.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Announcement $model
     * @return mixed
     */
    public function delete(User $user, Announcement $model) {
        return $user->hasPermission('announcements.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Announcement $model
     * @return mixed
     */
    public function restore(User $user, Announcement $model) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Announcement $model
     * @return mixed
     */
    public function forceDelete(User $user, Announcement $model) {
        //
    }
}
