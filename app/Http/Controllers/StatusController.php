<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

use App\Models\Task;
use App\Models\TaskStatus;

class StatusController extends Controller
{
  public function index(Request $req) : Response {
    $tasks = Task::query()
      ->whereNotIn('task_status_id', [
        TaskStatus::where('name', 'Completed')->first()->id,
        TaskStatus::where('name', 'Rejected')->first()->id,
      ])
      ->with(['task_template', 'user_assigned', 'task_status'])
      ->orderBy('created_at', 'asc')
      ->limit(12)
      ->get();

    return Inertia::render('status/(Index)' , ['pageTitle' => 'Status', 'tasks' => $tasks]);
  }
}
