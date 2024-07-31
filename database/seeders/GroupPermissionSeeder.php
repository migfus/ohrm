<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\GroupPermission;

class GroupPermissionSeeder extends Seeder
{
  public function run(): void {
    $data = [
      // NOTE: Group
      [
        'name' => 'index group',
        'display_name' => 'Index Group'
      ],
      [
        'name' => 'update group',
        'display_name' => 'Update Group'
      ],
      [
        'name' => 'destroy group',
        'display_name' => 'Delete Group'
      ],
      // NOTE: Tasks
      [
        'name' => 'create template_task',
        'display_name' => 'Create Template Task'
      ],
      [
        'name' => 'update template_task',
        'display_name' => 'Update Template Task'
      ],
      [
        'name' => 'destroy template_task',
        'display_name' => 'Delete Template Task'
      ]
    ];

    foreach($data as $row) {
      GroupPermission::create($row);
    }
  }
}
