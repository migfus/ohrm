<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use App\Models\TaskUserAssign;
use Illuminate\Database\Seeder;

use App\Models\User;

class TaskUserAssignSeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'user_id' => User::where('name', '[Admin User]')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', '[Staff User]')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Athena Jan I. Derayunan')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Charlotte G. Sanchez')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Divina S. Toquib')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Jernafernagen J. Delada')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],

      // NOTE: RSP
      [
        'user_id' => User::where('name', 'Charlotte G. Sanchez')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Applications')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Eunice Jane O. Sarausa')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Applications')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Eunice Jane O. Sarausa')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Job Order Contract/s')->first()->id
      ],
    ];

    foreach($data as $item) {
      TaskUserAssign::create($item);
    }
  }
}
