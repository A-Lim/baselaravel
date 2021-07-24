<?php
namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Models\PermissionModule;

class PermissionRepository implements IPermissionRepository {

     /**
     * {@inheritdoc}
     */
    public function list() {
        return PermissionModule::with('permissions')
            ->where('is_active', true)->get();
    }
}