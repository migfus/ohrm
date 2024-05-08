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
    public function run(): void {
      $this->settingTeam();

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
        'name' => 'head',
        'display_name' => 'Team Head',
        'description' => 'Unit Head for the team'
      ]);


      // NOTE PERMISSIONS
      $perm_create_user = Permission::create([
        'name' => 'user-create',
        'display_name' => 'User Create',
        'description' => 'Able to create a new user',
      ]);

      $perm_edit_user = Permission::create([
          'name' => 'user-edit',
          'display_name' => 'User Edit', // optional
          'description' => 'Able to edit an existing users', // optional
      ]);

      $perm_create_post = Permission::create([
        'name' => 'post-create',
        'display_name' => 'Post Create', // optional
        'description' => 'Able to create new post', // optional
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

    // NOTE: TEAMS
    private function settingTeam(): void {
      // NOTE: SYSTEM TEAM
      Team::create([
        'name' => 'system',
        'display_name' => 'System',
        'description' => 'System Configuration Team',
      ]);

      // NOTE: OHRM TEAM
      Team::create([
        'name' => 'ohrm',
        'display_name' => 'OHRM Team',
        'description' => 'These users are under from OHRM Team (Owner: OHRM Head)',
      ]);

      // NOTE: UNIT TEAMS
      Team::create([
        'name' => 'rsp',
        'display_name' => 'RSP - Recruitment, Selection & Placement Team',
        'description' => 'These users are under from RSP Unit (Owner: RSP Unit Head)',
      ]);
      Team::create([
        'name' => 'ld',
        'display_name' => 'LD - Learning & Development Team',
        'description' => 'These users are under from LD Unit (Owner: LD Unit Head)',
      ]);
      Team::create([
        'name' => 'cberu',
        'display_name' => 'CBERU - Compensation, Benefit & Employee Relations Unit Team',
        'description' => 'These users are under from CBERU Unit (Owner: CBERU Unit Head)',
      ]);
      Team::create([
        'name' => 'HRIS',
        'display_name' => 'HRIS - Human Resources Information System Team',
        'description' => 'These users are under from HRIS Unit (Owner: HRIS Unit Head)',
      ]);
      Team::create([
        'name' => 'PM',
        'display_name' => 'PM - Performance Management Team',
        'description' => 'These users are under from PM Unit (Owner: PM Unit Head)',
      ]);
    }
}
