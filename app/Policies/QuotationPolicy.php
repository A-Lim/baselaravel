<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quotation;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy {
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
        return $user->hasPermission('quotations.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Quotation $model
     * @return mixed
     */
    public function view(User $user, Quotation $model) {
        return $user->hasPermission('quotations.view') && 
            $this->user->hasStore($model->store_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user) {
        return $user->hasPermission('quotations.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Quotation $model
     * @return mixed
     */
    public function update(User $user, Quotation $model) {
        return $user->hasPermission('quotations.update') && 
            $this->user->hasStore($model->store_id);;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Quotation $model
     * @return mixed
     */
    public function delete(User $user, Quotation $model) {
        return $user->hasPermission('quotations.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Quotation $model
     * @return mixed
     */
    public function restore(User $user, Quotation $model) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Quotation $model
     * @return mixed
     */
    public function forceDelete(User $user, Quotation $model) {
        //
    }
}
