<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SystemSetting;
use App\Models\SystemSettingCategory;

use Carbon\Carbon;

class SystemSettingsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now();
        $generalCategory = SystemSettingCategory::create(['name' => 'General']);
        $authCategory = SystemSettingCategory::create(['name' => 'Authentication']);
        $socialCategory = SystemSettingCategory::create(['name' => 'Social']);
        
        $systemsettings = [
            ['systemsettingcategory_id' => $generalCategory->id, 'name' => 'Company Name', 'code' => 'company_name', 'description' => 'Allow public users to register to site.', 'value' => true, 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $generalCategory->id, 'name' => 'SSM Number', 'code' => 'ssm_no', 'description' => '', 'value' => 'none', 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $generalCategory->id, 'name' => 'Email', 'code' => 'company_email', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $generalCategory->id, 'name' => 'Phone', 'code' => 'company_phone', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],

            ['systemsettingcategory_id' => $authCategory->id, 'name' => 'Allow Public Registration', 'code' => 'allow_public_registration', 'description' => 'Allow public users to register to site.', 'value' => true, 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $authCategory->id, 'name' => 'Verification Type', 'code' => 'verification_type', 'description' => '', 'value' => 'none', 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $authCategory->id, 'name' => 'Default User Group', 'code' => 'default_usergroups', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],

            ['systemsettingcategory_id' => $socialCategory->id, 'name' => 'Facebook', 'code' => 'facebook', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $socialCategory->id, 'name' => 'Instagram', 'code' => 'instagram', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['systemsettingcategory_id' => $socialCategory->id, 'name' => 'Whatsapp', 'code' => 'whatsapp', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
        ];

        SystemSetting::insert($systemsettings);
    }
}
