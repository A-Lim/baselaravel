<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            UsersTableSeeder::class,
            UserGroupsTableSeeder::class,
            PermissionsTableSeeder::class,
            SystemSettingsTableSeeder::class,
            WidgetTypesTableSeeder::class,
            DashboardsTableSeeder::class
        ]);
    }
}
