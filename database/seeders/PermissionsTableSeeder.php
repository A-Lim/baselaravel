<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

use App\Models\Permission;
use App\Models\PermissionModule;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $permission_modules = [
            ['code' => 'users', 'name' => 'Users', 'description' => 'User module', 'is_active' => '1'],
            ['code' => 'usergroups', 'name' => 'User Groups', 'description' => 'User Groups module', 'is_active' => '1'],
            ['code' => 'systemsettings', 'name' => 'System Settings', 'description' => 'System Settings module', 'is_active' => '1'],
            ['code' => 'stores', 'name' => 'Stores', 'description' => 'Store module', 'is_active' => '1'],
            ['code' => 'clients', 'name' => 'Clients', 'description' => 'Client module', 'is_active' => '1'],
            ['code' => 'quotations', 'name' => 'Quotations', 'description' => 'Quotation module', 'is_active' => '1'],
        ];

        $permissions = [
            // users
            ['permission_module_id' => '1', 'code' => 'users.view', 'name' => 'View User', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.viewAny', 'name' => 'View Any Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.create', 'name' => 'Create Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.update', 'name' => 'Update Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.delete', 'name' => 'Delete Users', 'description' => ''],
            // usergroups
            ['permission_module_id' => '2', 'code' => 'usergroups.view', 'name' => 'View User Group', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.viewAny', 'name' => 'View Any User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.create', 'name' => 'Create User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.update', 'name' => 'Update User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.delete', 'name' => 'Delete User Groups', 'description' => ''],
            // systemsettings
            ['permission_module_id' => '3', 'code' => 'systemsettings.viewAny', 'name' => 'View Any System Settings', 'description' => ''],
            ['permission_module_id' => '3', 'code' => 'systemsettings.general.view', 'name' => 'View General System Settings', 'description' => ''],
            ['permission_module_id' => '3', 'code' => 'systemsettings.auth.view', 'name' => 'View Auth System Settings', 'description' => ''],
            ['permission_module_id' => '3', 'code' => 'systemsettings.update', 'name' => 'Update System Settings', 'description' => ''],
            // stores
            ['permission_module_id' => '4', 'code' => 'stores.view', 'name' => 'View Store', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'stores.viewAny', 'name' => 'View Any Stores', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'stores.create', 'name' => 'Create Stores', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'stores.update', 'name' => 'Update Stores', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'stores.delete', 'name' => 'Delete Stores', 'description' => ''],
            // client
            ['permission_module_id' => '5', 'code' => 'clients.view', 'name' => 'View Client', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'clients.viewAny', 'name' => 'View Any Clients', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'clients.create', 'name' => 'Create Clients', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'clients.update', 'name' => 'Update Clients', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'clients.delete', 'name' => 'Delete Clients', 'description' => ''],
            // quotation
            ['permission_module_id' => '6', 'code' => 'quotations.view', 'name' => 'View Quotation', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'quotations.viewAny', 'name' => 'View Any Quotations', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'quotations.create', 'name' => 'Create Quotations', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'quotations.createRevision', 'name' => 'Create Quotation Revision', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'quotations.update', 'name' => 'Update Quotations', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'quotations.delete', 'name' => 'Delete Quotations', 'description' => ''],
        ];

        PermissionModule::insert($permission_modules);
        Permission::insert($permissions);

        // cached to be used in authserviceprovider to register gates
        Cache::rememberForEver('permissions_with_usergroups', function() {
            return Permission::with('userGroups')->get();
        });
    }
}
