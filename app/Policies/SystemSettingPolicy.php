<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemSettingPolicy {
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
        return $user->can('systemsettings.viewAny') &&
            ($user->status == 'active' || $user->status == 'inactive');
    }

    /**
     * Determine whether the user can update systemsettings.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user) {
        return $user->can('systemsettings.update') &&
            $user->status == 'active';
    }
}
