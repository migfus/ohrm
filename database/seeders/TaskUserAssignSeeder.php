<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use App\Models\TaskUserAssign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class TaskUserAssignSeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'user_id' => User::where('name', '[Admin User]')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ]
    ];

    foreach($data as $item) {
      TaskUserAssign::create($item);
    }
  }
}
