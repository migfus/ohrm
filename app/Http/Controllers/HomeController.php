<?php
namespace App\Http\Controllers;


use App\Models\Group;
use App\Models\TaskPriority;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Carbon\Carbon;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskTemplate;

use App\Events\UpdateStatusPageEvent;

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
      // 'message' => [],
    ]);

    $task_template = TaskTemplate::where('id', $req->task_template_id)->first();

    $previous_task = Task::orderBy('created_at', 'DESC')->first();
    $task_id = 1;

    if($previous_task) {
      if(substr(strval($previous_task->id), 0, 6) == Carbon::now()->format('ymd')) {
        $task_id = substr(strval($previous_task->id), 6, 3) + 1;
      }
    }

    Task::create([
      'id' => Carbon::now()->format('ymd') . str_pad($task_id, 3, '0', STR_PAD_LEFT),
      'group_id' => $task_template->group_id,
      'task_template_id' => $req->task_template_id,
      'task_priority_id' => $req->task_priority_id,
      'task_status_id' => TaskStatus::where('name', 'Queuing')->first()->id,
      'task_status_at' => Carbon::now(),
      'message' => $req->message,
    ]);

    // event(new MakeRequestEvent([
    //   'message' => 'new Data',
    // ]));
    // broadcast(new MakeRequestEvent([]));
    UpdateStatusPageEvent::dispatch(['message' => 'new data']);

    return to_route('index')->with('success', $task_template->name . " is now on queue!");
  }
}
