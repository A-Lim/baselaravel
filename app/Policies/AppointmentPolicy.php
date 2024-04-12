<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy {
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
     * Determine whether the user can view any appointments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user) {
        return $user->hasPermission('appointment.viewAny');
    }

    /**
     * Determine whether the user can view the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return mixed
     */
    public function view(User $user, Appointment $appointment) {
        return $user->hasPermission('appointment.view');
    }

    /**
     * Determine whether the user can create appointments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('appointment.create');
    }

    /**
     * Determine whether the user can update the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return mixed
     */
    public function update(User $user, Appointment $appointment) {
        return $user->hasPermission('appointment.update');
    }

    /**
     * Determine whether the user can delete the appointment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Appointment  $appointment
     * @return mixed
     */
    public function delete(User $user, Appointment $appointment) {
        return $user->hasPermission('appointment.delete');
    }
}
