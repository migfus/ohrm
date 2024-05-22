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

      // SECTION ROLE
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

      $role_head = Role::create([
        'name' => 'head',
        'display_name' => 'Head',
        'description' => 'Head of the team',
      ]);


      // SECTION PERMISSIONS
      // NOTE: USERS
      $perm_user_create = Permission::create([
        'name' => 'user-create',
        'display_name' => 'User Create',
        'description' => 'Able to create a new user',
      ]);

      $perm_user_edit = Permission::create([
          'name' => 'user-edit',
          'display_name' => 'User Edit',
          'description' => 'Able to edit an existing users',
      ]);

      $perm_user_delete = Permission::create([
        'name' => 'user-delete',
        'display_name' => 'User Delete',
        'description' => 'Able to delete an existing user',
      ]);

      // NOTE: POST
      $perm_post_create = Permission::create([
        'name' => 'post-create',
        'display_name' => 'Post Create', // optional
        'description' => 'Able to create new post', // optional
      ]);

      $perm_post_self_edit = Permission::create([
        'name' => 'post-self-edit',
        'display_name' => 'Post Edit (Owned)',
        'description' => 'Able to modify their post',
      ]);

      $perm_post_self_delete = Permission::create([
        'name' => 'post-self-delete',
        'display_name' => 'Post Delete (Owned)',
        'description' => 'Able to delete their post',
      ]);

      // NOTE: GROUPS
      $perm_group_create = Permission::create([
        'name' => 'group-create',
        'display_name' => 'Group Create',
        'description' => 'Able to create new group',
      ]);

      $perm_group_self_edit = Permission::create([
        'name' => 'group-self-edit',
        'display_name' => 'Group Edit (Owned)',
        'description' => 'Able to modify their group',
      ]);

      $perm_group_self_delete = Permission::create([
        'name' => 'group-self-delete',
        'display_name' => 'Group Delete (Owned)',
        'description' => 'Able to delete their group',
      ]);

      $role_admin->syncPermissions([
        // NOTE: USERS
        $perm_user_create,
        $perm_user_edit,
        $perm_user_delete,
        // NOTE POST
        $perm_post_create,
        $perm_post_self_edit,
        $perm_post_self_delete,
        // NOTE GROUPS
        $perm_group_create,
        $perm_group_self_edit,
        $perm_group_self_delete,
      ]);

      $role_head->syncPermissions([
        // NOTE POST
        $perm_post_create,
        $perm_post_self_edit,
        $perm_post_self_delete,
        // NOTE GROUPS
        $perm_group_create,
        $perm_group_self_edit,
        $perm_group_self_delete,
      ]);

      $role_staff->syncPermissions([
        // NOTE POST
        $perm_post_create,
        $perm_post_self_edit,
        $perm_post_self_delete,
      ]);
    }

    // NOTE: TEAMS
    private function settingTeam(): void {
      // NOTE: SYSTEM TEAM
      Team::create([
        'name' => 'system',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/3067/3067451.png',
        'display_name' => 'System',
        'description' => 'System Configuration Team',
      ]);

      // NOTE: OHRM TEAM
      Team::create([
        'name' => 'ohrm',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/13728/13728428.png',
        'display_name' => 'OHRM Team',
        'description' => 'These users are under from OHRM Team (Owner: OHRM Head)',
      ]);

      // NOTE: UNIT TEAMS
      Team::create([
        'name' => 'rsp',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/2083/2083335.png',
        'display_name' => 'RSP - Recruitment, Selection & Placement Team',
        'description' => 'These users are under from RSP Unit (Owner: RSP Unit Head)',
      ]);
      Team::create([
        'name' => 'ld',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/10143/10143723.png',
        'display_name' => 'LD - Learning & Development Team',
        'description' => 'These users are under from LD Unit (Owner: LD Unit Head)',
      ]);
      Team::create([
        'name' => 'cberu',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/4115/4115705.png',
        'display_name' => 'CBERU - Compensation, Benefit & Employee Relations Unit Team',
        'description' => 'These users are under from CBERU Unit (Owner: CBERU Unit Head)',
      ]);
      Team::create([
        'name' => 'HRIS',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/2910/2910768.png',
        'display_name' => 'HRIS - Human Resources Information System Team',
        'description' => 'These users are under from HRIS Unit (Owner: HRIS Unit Head)',
      ]);
      Team::create([
        'name' => 'PM',
        'avatar' => 'https://cdn-icons-png.flaticon.com/128/1013/1013386.png',
        'display_name' => 'PM - Performance Management Team',
        'description' => 'These users are under from PM Unit (Owner: PM Unit Head)',
      ]);
    }
}
