<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\TaskPriority;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

use App\Models\Task;
use App\Models\TaskTemplate;

class HomeController extends Controller
{
  // ✅
  public function index(Request $req) : Response {
    $groups = Group::query()
      ->with('task_templates.task_priority.hero_icon')
      ->orderBy('created_at', 'ASC')
      ->get();

    $task_priorities = TaskPriority::get();

    return Inertia::render('home/(Index)' , [
      'pageTitle' => 'Home',
      'groups' => $groups,
      'task_priorities' => $task_priorities
    ]);
  }

  // ✏️
  function store(Request $req) : RedirectResponse {
    $req->validate([
      'task_template_id' => ['required', 'uuid'],
      'task_priority_id' => ['required', 'uuid'],
      'message' => [],
    ]);

    $task_template = TaskTemplate::where('id', $req->task_template_id)->first();

    // Task::create([
    //   'group_id' => $task_template->group_id,
    //   ''
    // ]);
    return to_route('index')->with('success', $task_template->name . " is now on queue!");
  }
}
