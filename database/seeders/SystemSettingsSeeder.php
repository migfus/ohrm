<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemSettings;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'name' => 'Title',
          'description' => 'Branding Name for the System',
          'config' => json_encode(['value' => 'Office of Human Resources Management'])
        ],
      ];

      foreach($data as $row) {
        SystemSettings::create($row);
      }
    }
}
