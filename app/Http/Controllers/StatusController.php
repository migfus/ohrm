<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;

use App\Models\Task;
use App\Models\TaskStatus;

class StatusController extends Controller
{
  public function index() : Response {
    $tasks = Task::query()
      ->whereNotIn('task_status_id', [
        TaskStatus::where('past_name', 'Completed')->first()->id,
        TaskStatus::where('past_name', 'Rejected')->first()->id,
      ])
      ->with(['task_template', 'user_assigned', 'task_status'])
      ->orderBy('created_at', 'asc')
      ->limit(12)
      ->get();

    return Inertia::render('status/(Index)' , ['page_title' => 'Status', 'tasks' => $tasks]);
  }
}
