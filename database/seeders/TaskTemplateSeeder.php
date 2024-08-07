<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Group;
use App\Models\TaskPriority;
use App\Models\TaskTemplate;

class TaskTemplateSeeder extends Seeder
{
  protected $task_priority = [];

  public function __construct() {
    $this->task_priority['urgent'] = TaskPriority::where('name', 'Urgent')->first()->id;
    $this->task_priority['high'] = TaskPriority::where('name', 'High')->first()->id;
    $this->task_priority['mid'] = TaskPriority::where('name', 'Mid')->first()->id;
    $this->task_priority['low'] = TaskPriority::where('name', 'Low')->first()->id;
    $this->task_priority['set aside'] = TaskPriority::where('name', 'Set Aside')->first()->id;
  }
    /**
     * Run the database seeds.
     */
  public function run(): void {
    $this->ohrmTasks(Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id);
    $this->rspTasks(Group::where('name', 'Recruitment, Selection and Placement')->first()->id);
    $this->ldTasks(Group::where('name', 'Learning and Development')->first()->id);
    $this->coberuTasks(Group::where('description', 'COBERU Group')->first()->id);
    $this->hrisTasks(Group::where('description', 'HRIS Group')->first()->id);
    $this->permaTasks(Group::where('description', 'PERMA Group')->first()->id);
  }
    private function ohrmTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['urgent'],
          'is_show' => true,
          'name' => 'Direct Request',
          'message' => 'This template is to work lol',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['high'],
          'is_show' => true,
          'name' => 'High Task',
          'message' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Mid task',
          'message' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['low'],
          'is_show' => true,
          'name' => 'Low Task',
          'message' => 'Work for your life!!',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['set aside'],
          'is_show' => true,
          'name' => 'Aside task',
          'message' => 'Work for your life!!',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
    private function rspTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Applications',
          'message' => 'Applicant application',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Job Order Contract/s',
          'message' => 'Follow up job order contract/s',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
    private function ldTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Seminar Request',
          'message' => 'Seminar Request',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
    private function coberuTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Retirement Request',
          'message' => 'Retirement Request',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Leave Request',
          'message' => 'Leave Request',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Outstanding Employee',
          'message' => 'Outstanding Employee',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Landbank Request',
          'message' => 'Landbank Request',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
    private function hrisTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'Biometrics Request',
          'message' => 'Biometrics Request',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'CSC ID Request',
          'message' => 'CSC ID Request',
        ],
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => '201 File Request',
          'message' => '201 File Request',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
    private function permaTasks($group_id) : void {
      $data = [
        [
          'group_id' => $group_id,
          'default_task_priority_id' => $this->task_priority['mid'],
          'is_show' => true,
          'name' => 'PeMIRES Request',
          'message' => 'PeMIRES Request',
        ],
      ];

      foreach($data as $item) {
        TaskTemplate::create($item);
      }
    }
}
