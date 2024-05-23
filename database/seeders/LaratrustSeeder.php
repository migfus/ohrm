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
        'icon' =>
          '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>',
        'display_name' => 'Staff',
        'description' => 'Staff who manage the system'
      ]);

      $role_admin = Role::create([
        'name' => 'admin',
        'icon' =>
          '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
          </svg>',
        'display_name' => 'Administrator',
        'description' => 'Administrator for the system.'
      ]);

      $role_head = Role::create([
        'name' => 'head',
        'icon' =>
          '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>',
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
        'avatar' => 'https://images.unsplash.com/photo-1617228679684-890412dc57a5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'cover' => 'https://images.unsplash.com/photo-1617228679684-890412dc57a5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'display_name' => 'System',
        'description' => 'System Configuration Team',
      ]);

      // NOTE: OHRM TEAM
      Team::create([
        'name' => 'ohrm',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1663011066468-e25570646a1a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'cover' => 'https://plus.unsplash.com/premium_photo-1663011066468-e25570646a1a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'display_name' => 'OHRM Team',
        'description' => 'These users are under from OHRM Team (Owner: OHRM Head)',
      ]);

      // NOTE: UNIT TEAMS
      Team::create([
        'name' => 'rsp',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1678871480778-060c5d9460c1?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'cover' => 'https://plus.unsplash.com/premium_photo-1678871480778-060c5d9460c1?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'display_name' => 'RSP - Recruitment, Selection & Placement Team',
        'description' => 'These users are under from RSP Unit (Owner: RSP Unit Head)',
      ]);
      Team::create([
        'name' => 'ld',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1665520347036-f52ddccc1d9a?q=80&w=1973&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'cover' => 'https://plus.unsplash.com/premium_photo-1665520347036-f52ddccc1d9a?q=80&w=1973&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'display_name' => 'LD - Learning & Development Team',
        'description' => 'These users are under from LD Unit (Owner: LD Unit Head)',
      ]);
      Team::create([
        'name' => 'cberu',
        'avatar' => 'https://images.unsplash.com/photo-1527525443983-6e60c75fff46?q=80&w=1970&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'cover' => 'https://images.unsplash.com/photo-1527525443983-6e60c75fff46?q=80&w=1970&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'display_name' => 'CBERU - Compensation, Benefit & Employee Relations Unit Team',
        'description' => 'These users are under from CBERU Unit (Owner: CBERU Unit Head)',
      ]);
      Team::create([
        'name' => 'HRIS',
        'avatar' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlicmFyeXxlbnwwfHwwfHx8MA%3D%3D',
        'cover' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlicmFyeXxlbnwwfHwwfHx8MA%3D%3D',
        'display_name' => 'HRIS - Human Resources Information System Team',
        'description' => 'These users are under from HRIS Unit (Owner: HRIS Unit Head)',
      ]);
      Team::create([
        'name' => 'PM',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1684966119402-e237566d4576?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cGVyZm9ybWFuY2V8ZW58MHx8MHx8fDA%3D',
        'cover' => 'https://plus.unsplash.com/premium_photo-1684966119402-e237566d4576?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cGVyZm9ybWFuY2V8ZW58MHx8MHx8fDA%3D',
        'display_name' => 'PM - Performance Management Team',
        'description' => 'These users are under from PM Unit (Owner: PM Unit Head)',
      ]);
    }
}
