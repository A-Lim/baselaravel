<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\UserGroup;
use Carbon\Carbon;

class UserGroupsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $userGroups = [
            ['code' => 'superadmin', 'name' => 'Super Admin', 'status' => 'active', 'is_admin' => true, 'created_by' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'normal', 'name' => 'Normal User', 'status' => 'active', 'is_admin' => false, 'created_by' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        UserGroup::insert($userGroups);

        $user = User::whereEmail('alexiuslim1994@gmail.com')->firstOrFail();
        $user->assignUserGroup('superadmin');
    }
}