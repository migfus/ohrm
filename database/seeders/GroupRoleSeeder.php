<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\GroupRole;
use App\Models\GroupPermission;

class GroupRoleSeeder extends Seeder
{
  public function run(): void {
    GroupRole::create([
      'name' => 'admin',
      'display_name' => 'Administrator',
      'description' => 'Users who administrate the group.',
      'icon_name' => 'star_micro',
    ])
      ->group_permission_role()
      ->sync([
        GroupPermission::where('name', 'index group')->first()->id,
        GroupPermission::where('name', 'update group')->first()->id,
        GroupPermission::where('name', 'destroy group')->first()->id,

        GroupPermission::where('name', 'create template_task')->first()->id,
        GroupPermission::where('name', 'update template_task')->first()->id,
        GroupPermission::where('name', 'destroy template_task')->first()->id,
      ]);

    GroupRole::create([
      'name' => 'moderator',
      'display_name' => 'Moderator',
      'description' => 'Users who moderate the group.',
      'icon_name' => 'users_micro'
    ])
      ->group_permission_role()
      ->sync([
        GroupPermission::where('name', 'index group')->first()->id,
        GroupPermission::where('name', 'create template_task')->first()->id,
        GroupPermission::where('name', 'update template_task')->first()->id,
        GroupPermission::where('name', 'destroy template_task')->first()->id,
      ]);

    GroupRole::create([
      'name' => 'member',
      'display_name' => 'Member',
      'description' => 'Members lists.',
      'icon_name' => 'at-symbol_micro'
    ])
      ->group_permission_role()
      ->sync([
        GroupPermission::where('name', 'index group')->first()->id,
      ]);

    GroupRole::create([
      'name' => 'removed',
      'display_name' => 'Removed',
      'description' => 'Removed Member lists.',
      'icon_name' => 'x-circle_micro'
    ])
      ->group_permission_role();
  }
}
