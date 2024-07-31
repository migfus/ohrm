<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Group;
use App\Models\Task;
use Faker\Core\Uuid;

Interface Test {

}

class TaskController extends Controller
{
  public function index(Request $req) : Response {
    $req->validate([
      'group_id' => ['required', 'uuid'],
    ]);
    $IndexRequest = new IndexRequest($req);

    $group = Group::find($IndexRequest->group_id);

    $tasks = Task::where('group_id', $req->group_id)->paginate(10);

    return Inertia::render('status/(Index)' , ['page_title' => "$group->name Tasks", 'tasks' => $tasks]);
  }
}

Class IndexRequest {
  public Uuid $group_id;

  public function __construct(Request $req) {
    $this->group_id = $req->group_id;
  }
}
