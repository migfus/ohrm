<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSettings;
use App\Models\SystemSettingCategory;
use App\Models\SystemSettingType;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $category_general = SystemSettingCategory::create([
        'name' => 'General',
        'sort_id' => 1,
        'description' => 'The system\'s representation settings',
        'href' => 'general'
      ]);
      // $category_test = SystemSettingCategory::create([
      //   'name' => 'Test',
      //   'sort_id' => 2,
      //   'description' => 'The test Settings',
      //   'href' => 'test'
      // ]);

      $type_text = SystemSettingType::create([
        'name' => 'text'
      ]);
      $type_avatar = SystemSettingType::create([
        'name' => 'avatar'
      ]);

      $data = [
        [
          'name' => 'System Name (Title)', // NOTE hard coded to HandleInertiaRequests, [Remember to change if you do]
          'sort_id' => 1,
          'system_setting_type_id' => $type_text->id,
          'system_setting_category_id' => $category_general->id,
          'description' => 'Branding Name for the System',
          'value' => 'Office of Human Resources Management'
        ],
        [
          'name' => 'System Logo', // NOTE hard coded to HandleInertiaRequests, [Remember to change if you do]
          'sort_id' => 2,
          'system_setting_type_id' => $type_avatar->id,
          'system_setting_category_id' => $category_general->id,
          'description' => 'Branding Name for the System',
          'value' => '/assets/logo.png'
        ],
        [
          'name' => 'System Small Logo (for page title)', // NOTE hard coded to HandleInertiaRequests, [Remember to change if you do]
          'sort_id' => 3,
          'system_setting_type_id' => $type_avatar->id,
          'system_setting_category_id' => $category_general->id,
          'description' => 'Branding Name for the System',
          'value' => '/assets/logo-sm.png'
        ],
        // [
        //   'name' => 'Test',
        //   'sort_id' => 1,
        //   'system_setting_type_id' => $type_text->id,
        //   'system_setting_category_id' => $category_test->id,
        //   'description' => 'Test Settiog',
        //   'value' => 'Testing Value'
        // ],
      ];

      foreach($data as $row) {
        SystemSettings::create($row);
      }
    }
}
