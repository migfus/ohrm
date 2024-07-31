<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
  public function run(): void {
    $data = [
      ['name' => 'Queuing',   'hero_icon' => 'clock_micro'], // default
      ['name' => 'Processing','hero_icon' => 'arrow-path_micro'],
      ['name' => 'Completed', 'hero_icon' => 'check-circle_micro'],
      ['name' => 'Rejected',  'hero_icon' => 'x-circle_micro'],
    ];

    foreach($data as $item) {
      TaskStatus::create($item);
    }
  }
}
