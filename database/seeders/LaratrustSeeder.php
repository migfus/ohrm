<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Team;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // NOTE ROLE
      $team_default = Team::create([
        'name' => 'default',
        'display_name' => 'Default',
        'description' => 'Default Team',
      ]);

      $team_recruit = Team::create([
        'name' => 'recruit',
        'display_name' => 'Recruitment Team',
        'description' => 'Recruitment Team',
      ]);

      // NOTE ROLE
      $role_staff = Role::create([
        'name' => 'staff',
        'display_name' => 'Staff',
        'description' => 'Staff who manage the system'
      ]);

      $role_admin = Role::create([
        'name' => 'admin',
        'display_name' => 'Administrator',
        'description' => 'Administrator for the system.'
      ]);

      Role::create([
        'name' => 'unit head',
        'display_name' => 'Unit Head',
        'description' => 'Unit Head for the groups'
      ]);
      Role::create([
        'name' => 'office head',
        'display_name' => 'Office Head',
        'description' => 'Office  Head for the groups'
      ]);


      // NOTE PERMISSIONS
      $perm_create_user = Permission::create([
        'name' => 'create-user',
        'display_name' => 'Create User',
        'description' => 'create new user',
      ]);

      $perm_edit_user = Permission::create([
          'name' => 'edit-user',
          'display_name' => 'Edit Users', // optional
          'description' => 'edit existing users', // optional
      ]);

      $perm_create_post = Permission::create([
        'name' => 'create-post',
        'display_name' => 'Create Post', // optional
        'description' => 'create new post', // optional
      ]);

      $role_admin->syncPermissions([
        // NOTE POST
        $perm_create_post,
        // NOTE USERS
        $perm_create_user,
        $perm_edit_user,
      ]);

      $role_staff->syncPermissions([
        // NOTE POST
        $perm_create_post,
      ]);
    }
}
