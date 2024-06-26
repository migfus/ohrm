<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\TaskPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TaskTemplate;

class TaskTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // NOTE: Groups
      $group_ohrm_id = Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id;

      // NOTE: Task Priorities
      $task_priority_urgent_id = TaskPriority::where('name', 'Urgent')->first()->id;
      $task_priority_high_id = TaskPriority::where('name', 'High')->first()->id;
      $task_priority_mid_id = TaskPriority::where('name', 'Mid')->first()->id;
      $task_priority_low_id = TaskPriority::where('name', 'Low')->first()->id;
      $task_priority_aside_id = TaskPriority::where('name', 'Set Aside')->first()->id;

      $data = [
        [
          'group_id' => $group_ohrm_id,
          'default_task_priority_id' => $task_priority_urgent_id,
          'is_show' => true,
          'name' => 'Direct Request',
          'description' => 'This template is to work lol',
        ],
        [
          'group_id' => $group_ohrm_id,
          'default_task_priority_id' => $task_priority_high_id,
          'is_show' => true,
          'name' => 'High Task',
          'description' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_ohrm_id,
          'default_task_priority_id' => $task_priority_mid_id,
          'is_show' => true,
          'name' => 'Mid task',
          'description' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_ohrm_id,
          'default_task_priority_id' => $task_priority_low_id,
          'is_show' => true,
          'name' => 'Low Task',
          'description' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_ohrm_id,
          'default_task_priority_id' => $task_priority_aside_id,
          'is_show' => true,
          'name' => 'Aside task',
          'description' => 'Work for your life!!',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
}
