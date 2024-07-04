<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\TaskTemplate;
use App\Models\TaskUserAccess;
use App\Models\User;

class TaskSeeder extends Seeder
{
  public function run(): void
  {
    $data = [
      [
        'id' => 2406270001,
        'task_template_id' => TaskTemplate::where('name', 'High Task')->first()->id,
        'group_id' => TaskTemplate::where('name', 'High Task')->first()->group_id,
        'task_priority_id' => TaskPriority::where('name', 'Mid')->first()->id,
        'task_status_id' => TaskStatus::where('name', 'Queuing')->first()->id,
        'task_status_at' => Carbon::now(),
      ]
    ];

    foreach($data as $item) {
      Task::create($item);
    }
  }
}
