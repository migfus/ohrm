<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\TaskUserAccess;
use App\Models\User;

class TaskSeeder extends Seeder
{
  public function run(): void
  {
    $data = [
      [
        'id' => 240627001,
        'task_user_access_id' => TaskUserAccess::where('user_id', User::where('name', 'Eunice Jane O. Sarausa')->first()->id)->first()->id,
        'task_priority_id' => TaskPriority::where('name', 'Mid')->first()->id,
        'task_status_id' => TaskStatus::where('name', 'Pending')->first()->id,
      ]
    ];

    foreach($data as $item) {
      Task::create($item);
    }
  }
}
