<?php

namespace Database\Seeders;

use App\Models\SystemSettings;
use App\Models\TaskStatus;
use App\Models\TaskTemplate;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
        HeroIconSeeder::class,
        LaratrustSeeder::class,
        SystemSettingsSeeder::class,
        GroupSeeder::class,
        GroupPermissionSeeder::class,
        GroupRoleSeeder::class,

        UserSeeder::class,

        TaskPrioritySeeder::class,
        TaskTemplateSeeder::class,
        TaskUserAccessSeeder::class,
        TaskStatusSeeder::class,
        TaskSeeder::class,
        PostTypeSeeder::class,
        PostSeeder::class,
        PostContentSeeder::class,
      ]);
    }
}
