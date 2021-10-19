<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Dashboard;

class DashboardsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $dashboard = [
            'uuid' => '71b6ab41-f326-4241-91a5-00a9fcd2677c',
            'name' => 'Default Dashboard',
            'public' => true,
            'created_by' => 1,
        ];

        Dashboard::create($dashboard);
    }
}