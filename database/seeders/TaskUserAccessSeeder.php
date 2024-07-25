<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use App\Models\TaskUserAccess;
use Illuminate\Database\Seeder;

use App\Models\User;

class TaskUserAccessSeeder extends Seeder
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
        'user_id' => User::where('name', 'Athens Radha')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Charlno Loukas')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Divine S. Sionann')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Jerna Bernardina')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Direct Request')->first()->id
      ],

      // NOTE: RSP
      [
        'user_id' => User::where('name', 'Charlno Loukas')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Applications')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Eunight Lachtnae')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Applications')->first()->id
      ],
      [
        'user_id' => User::where('name', 'Eunight Lachtnae')->first()->id,
        'task_template_id' => TaskTemplate::where('name', 'Job Order Contract/s')->first()->id
      ],
    ];

    foreach($data as $item) {
      TaskUserAccess::create($item);
    }
  }
}
