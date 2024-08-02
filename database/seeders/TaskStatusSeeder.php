<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'present_name' => 'Queue',
        'past_name' => 'Queuing',
        'hero_icon' => 'clock_micro'
      ], // default
      [
        'present_name' => 'Process',
        'past_name' => 'Processing',
        'hero_icon' => 'arrow-path_micro'
      ],
      [
        'present_name' => 'Complete',
        'past_name' => 'Completed',
        'hero_icon' => 'check-circle_micro'
      ],
      [
        'present_name' => 'Reject',
        'past_name' => 'Rejected',
        'hero_icon' => 'x-circle_micro'
      ],
    ];

    foreach($data as $item) {
      TaskStatus::create($item);
    }
  }
}
