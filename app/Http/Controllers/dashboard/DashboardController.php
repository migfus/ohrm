<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\TaskUserAccess;
use App\Models\Task;

class DashboardController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('dashboard/(Index)', [
      'page_title' => 'Dashboard',
      'tasks' => $this->getTasks($req),
    ]);
  }

    private function getTasks($req) {
      $task_user_assigned = TaskUserAccess::query()
        ->where('user_id', $req->user()->id)
        ->with(['task_template'])
        ->get();

      $task_template_ids = $task_user_assigned->pluck('task_template_id')->toArray();

      $tasks = Task::query()
        ->whereNull('user_assigned_id')
        ->orWhere('user_assigned_id', $req->user()->id)
        ->with(['user_assigned'])
        ->whereHas('task_template', function ($q) use($task_template_ids) {
          $q->whereIn('id', $task_template_ids);
        })
        ->get();

      return $tasks;
    }
}
