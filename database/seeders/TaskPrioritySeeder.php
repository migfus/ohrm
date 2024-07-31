<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TaskPriority;

class TaskPrioritySeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'name' => 'Urgent',
        'color' => 'dc2626', // red | 600
        'hero_icon' => 'exclamation-triangle_micro'
      ],
      [
        'name' => 'High',
        'color' => 'ea580c', // orange | 600
        'hero_icon' => 'document-arrow-up_micro'
      ],
      [
        'name' => 'Mid',
        'color' => 'ca8a04', // yellow | 600
        'hero_icon' => 'document-minus_micro'
      ],
      [
        'name' => 'Low',
        'color' => '16a34a', // green | 600
        'hero_icon' => 'document-arrow-down_micro'
      ],
      [
        'name' => 'Set Aside',
        'color' => '2563eb', // blue | 600
        'hero_icon' => 'face-smile_micro'
      ],
    ];

    foreach($data as $item) {
      TaskPriority::create($item);
    }
  }
}
