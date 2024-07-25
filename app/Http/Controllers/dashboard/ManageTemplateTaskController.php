<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\TaskTemplate;
use App\Models\TaskUserAccess;
use App\Models\GroupMember;
use App\Models\Task;

class ManageTemplateTaskController extends Controller
{
  // ✏️
  public function edit(string $id) : Response {
    $template_task = TaskTemplate::query()
      ->where('id', $id)
      ->with('group')
      ->first();
    $task_user_access = TaskUserAccess::query()
      ->where('task_template_id', $template_task->id)
      ->with('user')
      ->get();

    $tasks = Task::query()
      ->where('task_template_id', $id)
      ->with([
        'user_assigned.user',
        'task_priority.hero_icon',
        'task_status.hero_icon',
        'task_template'
      ])
      ->limit(10)
      ->orderBy('created_at', 'desc')
      ->get();

    return Inertia::render('dashboard/manage-template-tasks/(Edit)', [
      'page_title' => 'Edit Template Task',
      'task_template' => $template_task,
      'task_user_access' => $task_user_access,
      'tasks' => $tasks,
    ]);
  }

  // ✅
  public function update(Request $req, string $id) : RedirectResponse {
    $req->validate([
      'type' => ['required']
    ]);
    $msg = ['title' => 'Updated', 'content' => 'Successfuly Updated'];

    switch($req->type) {
      // ✅
      case 'basic':
        $this->updateBasic($req, $id);
        $msg = ['title' => 'Information Changed', 'content' => 'Successfuly Updated'];
        break;
      // ✅
      case 'assign-user':
        $this->assignUser($req, $id);
        $msg = ['title' => 'Member Assigned', 'content' => 'Successfuly Assigned New User'];
        break;
      // ✅
      case 'unassign-user':
        $this->unassignUser($req, $id);
        $msg = ['title' => 'Member Removed', 'content' => 'Successfuly Removed User'];
        break;
      default:
        return to_route('dashboard.manage-template-tasks.edit', ['manage_template_task' => $id])
          ->withErrors(['type' => 'Invalid Type!']);
    }

    return to_route('dashboard.manage-template-tasks.edit', ['manage_template_task' => $id])
      ->with('success', $msg);
  }
    // ✅
    private function updateBasic(Request $req, string $id) : void {
      $req->validate([
        'name'    => ['required'],
        'message' => ['required'],
        'show'    => ['required', 'boolean'],
      ]);

      TaskTemplate::find($id)->update([
        'name'    => $req->name,
        'message' => $req->message,
        'is_show' => $req->show ? true : false,
      ]);
    }
    // ✅
    private function assignUser(Request $req, string $id) : void {
      $req->validate([
        'user_id' => ['required', 'uuid'],
      ]);

      TaskUserAccess::create([
        'task_template_id' => $id,
        'user_id' => $req->user_id,
      ]);
    }
    // ✅
    private function unassignUser(Request $req, string $id) : void {
      $req->validate([
        'task_user_access_id' => ['required', 'uuid'],
      ]);

      TaskUserAccess::where('id', $req->task_user_access_id)->delete();
    }

  // ✅
  public function userComboBox(Request $req, $groupId) : JsonResponse {
    $req->validate([
      'task_template_id' => ['required', 'uuid'],
    ]);

    $dont_include_users = [];
    $members = TaskUserAccess::query()
      ->where('task_template_id', $req->task_template_id)
      ->with('user')
      ->get();

    foreach($members as $row) {
      $dont_include_users[]  = $row->user['id'];
    }

    $members = GroupMember::query()
      ->where('group_id', $groupId)
      ->whereNotIn('user_id', $dont_include_users)
      ->whereHas('user', function($q) use($req){
        $q->where('name', 'LIKE', '%'. $req->search. '%');
      })
      ->limit(5)
      ->get();

    return response()->json(
      $members->map(function ($row) {
        return [
          'id'     => $row->user['id'],
          'name'   => $row->user['name'],
          'avatar' => $row->user['avatar'],
        ];
      })
    );
  }
}
