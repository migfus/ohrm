<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

use App\Models\Group;
use App\Models\GroupTaskActivity;

class GroupSeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'name' => 'Office of Human Resources Management Office (OHRM)',
        'description' => 'OHRM Group',
        'cover' => 'https://plus.unsplash.com/premium_photo-1674055047689-8139fad222db?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1674055047689-8139fad222db?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => false,
      ],
      [
        'name' => 'Recruitment, Selection and Placement',
        'description' => 'RSP Group',
        'cover' => 'https://plus.unsplash.com/premium_photo-1676666379134-12c878a00283?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://plus.unsplash.com/premium_photo-1676666379134-12c878a00283?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => true,
      ],
      [
        'name' => 'Learning and Development',
        'description' => 'LAD Group',
        'cover' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2128&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2128&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => true,
      ],
      [
        'name' => 'Compensation, Benefits and Employee Relations Unit',
        'description' => 'COBERU Group',
        'cover' => 'https://images.unsplash.com/photo-1527525443983-6e60c75fff46?q=80&w=1970&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://images.unsplash.com/photo-1527525443983-6e60c75fff46?q=80&w=1970&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => true,
      ],
      [
        'name' => 'Human Resource Information System Unit Process',
        'description' => 'HRIS Group',
        'cover' => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => true,
      ],
      [
        'name' => 'Performance Management',
        'description' => 'PERMA Group',
        'cover' => 'https://images.unsplash.com/photo-1606326608690-4e0281b1e588?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'avatar' => 'https://images.unsplash.com/photo-1606326608690-4e0281b1e588?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'is_visible' => true,
      ]
    ];

    foreach($data as $row) {
      $group = Group::create($row);

      GroupTaskActivity::create([
        'group_id' => $group->id,
        'log_at' => Carbon::now()->subDays(1),
        'count' => 0,
      ]);
    }
  }
}
