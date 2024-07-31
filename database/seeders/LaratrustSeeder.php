<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class LaratrustSeeder extends Seeder
{
  public function run(): void {
    // SECTION ROLE
    $role_staff = Role::create([
      'name' => 'staff',
      'icon_name' => 'identification_micro',
      'display_name' => 'Staff',
      'description' => 'Staff who manage the system'
    ]);

    $role_admin = Role::create([
      'name' => 'admin',
      'icon_name' => 'star_micro',
      'display_name' => 'Administrator',
      'description' => 'Administrator for the system.'
    ]);

    $role_head = Role::create([
      'name' => 'head',
      'icon_name' => 'users_micro',
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
}
