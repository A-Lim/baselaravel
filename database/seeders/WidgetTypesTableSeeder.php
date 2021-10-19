<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\WidgetType;

class WidgetTypesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $widgetTypes = [
            [
                'category' => 'users', 
                'name' => 'Users Count',
                'type' => 'users-count',
                'icon' => '{"type":"user","theme":"outline"}',
                'configurations' => '',
                'rows' => 1,
                'cols' => 2,
                'dragEnabled' => true,
                'resizeEnabled' => false,
                'compactEnabled' => true,
            ],
            [
                'category' => 'announcements', 
                'name' => 'Announcements Listing',
                'type' => 'announcements-listing',
                'icon' => '{"type":"table","theme":"outline"}',
                'configurations' => null,
                'rows' => 3,
                'cols' => 3,
                'dragEnabled' => true,
                'resizeEnabled' => true,
                'compactEnabled' => true,
            ],
            [
                'category' => 'announcements', 
                'name' => 'Announcements Count',
                'type' => 'announcements-count',
                'icon' => '{"type":"notification","theme":"outline"}',
                'configurations' => null,
                'rows' => 1,
                'cols' => 2,
                'dragEnabled' => true,
                'resizeEnabled' => false,
                'compactEnabled' => true,
            ],
        ];

        WidgetType::insert($widgetTypes);
    }
}