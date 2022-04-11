<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            UsersTableSeeder::class,
            PermissionsTableSeeder::class,
            UserGroupsTableSeeder::class,
            SystemSettingsTableSeeder::class,
            WidgetTypesTableSeeder::class,
            DashboardsTableSeeder::class
        ]);
    }
}
