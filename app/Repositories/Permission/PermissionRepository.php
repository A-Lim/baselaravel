<?php
namespace App\Repositories\Permission;

use App\Models\PermissionModule;

class PermissionRepository implements IPermissionRepository {

    public function list() {
        return PermissionModule::with('permissions')
            ->where('is_active', true)->get();
    }
}
