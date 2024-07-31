<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Group;
use App\Models\Task;

class TaskController extends Controller
{
  public function index(Request $req) : Response {
    $req->validate([
      'group_id' => ['required', 'uuid'],
    ]);

    $group = Group::find($req->group_id);

    $tasks = Task::where('group_id', $req->group_id)->paginate(10);

    return Inertia::render('status/(Index)' , ['page_title' => "$group->name Tasks", 'tasks' => $tasks]);
  }
}
