<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

use App\Models\TaskUserAccess;
use App\Models\Task;
use App\Models\UserTaskActivity;
use App\Models\TaskStatus ;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('dashboard/index/(Index)', [
      'page_title' => 'Dashboard',
      'queuing_tasks' => $this->getQueuingTasks($req),
      'processing_tasks' => $this->getProcessing($req),
      'completed_tasks' => $this->getCompleted($req),
      'user_activities' => $this->getUserLogs($req->user()->id),
      'task_status' => $this->getTaskStatus()
    ]);
  }
    private function getQueuingTasks($req) : Collection {
      $req->validate(['search' => []]);

      $task_template_ids = TaskUserAccess::query()
        ->where('user_id', $req->user()->id)
        ->with(['task_template'])
        ->get()
        ->pluck('task_template_id')
        ->toArray();

      return Task::query()
        ->whereNull('user_assigned_id')
        ->when($req->search, function($q) use($req) {
          $q->where(function($q_) use($req) {
            $q_->where('name', 'LIKE', '%'.$req->search.'%')
              ->orWhere('message', 'LIKE', '%'.$req->search.'%');
          });
        })
        ->with(['user_assigned', 'task_priority.hero_icon', 'task_template.group', 'task_status.hero_icon'])
        ->whereHas('task_template', function ($q) use($task_template_ids) {
          $q->whereIn('id', $task_template_ids);
        })
        ->orderBy('created_at', 'desc')
        ->get();
    }
    private function getProcessing($req) : Collection {
      $req->validate(['search' => []]);

      return Task::query()
        ->where('user_assigned_id', $req->user()->id) // only assigned tasks
        ->where('task_status_id', TaskStatus::where('past_name', 'Processing')->first()->id)
        ->when($req->search != '', function($q) use($req) {
          $q->where(function($q_) use($req) {
            $q_->where('name', 'LIKE', '%'.$req->search.'%')
              ->orWhere('message', 'LIKE', '%'.$req->search.'%');
          });
        })
        ->with([
          'user_assigned',
          'task_priority.hero_icon',
          'task_template.group',
          'task_status.hero_icon'
        ])
        ->orderBy('task_status_at', 'desc')
        ->get();
    }
    private function getCompleted($req) : Collection {
      $req->validate(['search' => []]);

      return Task::query()
        ->where('user_assigned_id', $req->user()->id) // only assigned tasks
        ->where(function($q) {
          $q->where('task_status_id', TaskStatus::where('past_name', 'Completed')->first()->id)
            ->orWhere('task_status_id', TaskStatus::where('past_name', 'Rejected')->first()->id);
        })
        ->when($req->search != "", function($q) use($req) {
          $q->where(function($q_) use($req) {
            $q_->where('name', 'LIKE', '%'.$req->search.'%')
              ->orWhere('message', 'LIKE', '%'.$req->search.'%');
          });
        })
        ->with([
          'user_assigned',
          'task_priority.hero_icon',
          'task_template.group',
          'task_status.hero_icon'
        ])
        ->orderBy('task_status_at', 'desc')
        ->get();
    }
    private function getUserLogs($user_id) : Object {
      // NOTE: Loop until record exists (backward date)
      // NOTE: THis will cause loop, upon user created, create also a user-activity in previous day as 0
      $date = Carbon::now()->subDays(1)->format('Y-m-d'); // check previous day activity
      while($date != null) {
        $user_activity = UserTaskActivity::where('log_at', $date)->first();
        if($user_activity) {
          $date = null;
        }
        else {
          UserTaskActivity::create([
            'user_id' => $user_id,
            'count' => Task::where('user_assigned_id', $user_id)->where('created_at', $date)->count(),
            'log_at' => $date,
          ]);
          $date = Carbon::parse($date)->subDays(1)->format('Y-m-d');
        }
      }

      // NOTE: Returns all relative whole year logs from start(the beginning but limit to last year).
      return UserTaskActivity::query()
        ->where('user_id', $user_id)
        ->where('log_at', '>=', Carbon::now()->subYear())
        ->orderBy('log_at', 'desc')
        ->get()
        ->map(function($irem) {
          return ['date' => $irem['log_at'], 'count' => $irem['count']];
        });
    }
    private function getTaskStatus() : Collection {
      return TaskStatus::whereNot('past_name', 'Queuing')->with('hero_icon')->get();
    }

  public function update(Request $req, $task_id) : RedirectResponse {
    $req->validate([
      'task_status_id' => ['required', 'uuid']
    ]);

    $task = Task::query()
      ->where('id', $task_id)
      ->update([
        'user_assigned_id' => auth()->user()->id,
        'user_assigned_at' => Carbon::now(),
        'task_status_id'   => $req->task_status_id,
        'task_status_at'   => Carbon::now(),
      ]);

    return to_route('dashboard.index')
      ->with('success', ['title' => 'Task Marked', 'content' => 'Updated']);
  }
}
