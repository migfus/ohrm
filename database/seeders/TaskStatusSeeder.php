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
        'hero_icon' => 'clock_micro',
        'text_color'=> '3c493e',  // brand-700?
        'bg_color'=> 'eff2ef',    // brand-50
      ], // default
      [
        'present_name' => 'Process',
        'past_name' => 'Processing',
        'hero_icon' => 'arrow-path_micro',
        'text_color'=> '0f766e',  // cyan-700?
        'bg_color'=> 'ecfeff',    // cyan-50
      ],
      [
        'present_name' => 'Complete',
        'past_name' => 'Completed',
        'hero_icon' => 'check-circle_micro',
        'text_color'=> '15803d',  // green-700?
        'bg_color'=> 'f0fdf4',    // green-50
      ],
      [
        'present_name' => 'Reject',
        'past_name' => 'Rejected',
        'hero_icon' => 'x-circle_micro',
        'text_color'=> 'b91c1c',  // red-700?
        'bg_color'=> 'fef2f2',    // red-50
      ],
    ];

    foreach($data as $item) {
      TaskStatus::create($item);
    }
  }
}
