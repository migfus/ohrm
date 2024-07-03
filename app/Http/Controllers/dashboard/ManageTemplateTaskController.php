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
    $templateTask = TaskTemplate::query()
      ->where('id', $id)
      ->with('group')
      ->first();
    $taskUserAccess = TaskUserAccess::query()
      ->where('task_template_id', $templateTask->id)
      ->with(['user', 'tasks' => function ($q) {
        $q->limit(20);
      }])
      ->get();

    $tasks = [];
    foreach($taskUserAccess as $row) {
      $tasks = [
        ...$tasks,
        ...Task::query()
          ->where('task_user_access_id', $row->id)
          ->with(['task_user_access.user', 'task_priority.hero_icon', 'task_status.hero_icon'])
          ->limit(10)
          ->orderBy('created_at', 'desc')
          ->get()
          ->toArray()
      ];
    }

    return Inertia::render('dashboard/manage-template-tasks/(Edit)', [
      'pageTitle' => 'Edit Template Task',
      'taskTemplate' => $templateTask,
      'taskUserAccess' => $taskUserAccess,
      'tasks' => $tasks,
    ]);
  }

  // ✅
  public function update(Request $req, string $id) : RedirectResponse {
    $req->validate([
      'type' => ['required']
    ]);

    switch($req->type) {
      // ✅
      case 'basic':
        $this->UpdateBasic($req, $id);
        break;
      // ✅
      case 'assign-user':
        $this->AssignUser($req, $id);
        break;
      // ✅
      case 'unassign-user':
        $this->UnassignUser($req, $id);
        break;
      default:
        return to_route('dashboard.manage-template-tasks.edit', ['manage_template_task' => $id])->withErrors(['type' => 'Invalid Type!']);
    }

    return to_route('dashboard.manage-template-tasks.edit', ['manage_template_task' => $id]);
  }
    // ✅
    private function UpdateBasic(Request $req, string $id) : void {
      $req->validate([
        'name' => ['required'],
        'description' => ['required']
      ]);

      TaskTemplate::find($id)->update([
        'name' => $req->name,
        'description' => $req->description,
      ]);
    }
    // ✅
    private function AssignUser(Request $req, string $id) : void {
      $req->validate([
        'userId' => ['required', 'uuid'],
      ]);

      TaskUserAccess::create([
        'task_template_id' => $id,
        'user_id' => $req->userId,
      ]);
    }
    // ✅
    private function UnassignUser(Request $req, string $id) : void {
      $req->validate([
        'TaskUserAccessId' => ['required', 'uuid'],
      ]);

      TaskUserAccess::where('id', $req->TaskUserAccessId)->delete();
    }

  // ✅
  public function UserComboBox(Request $req, $groupId) : JsonResponse {
    $req->validate([
      'taskTemplateId' => ['required', 'uuid'],
    ]);

    $dontIncludeUsers = [];
    $members = TaskUserAccess::query()
      ->where('task_template_id', $req->taskTemplateId)
      ->with('user')
      ->get();

    foreach($members as $row) {
      $dontIncludeUsers[]  = $row->user['id'];
    }

    $members = GroupMember::query()
      ->where('group_id', $groupId)
      ->whereNotIn('user_id', $dontIncludeUsers)
      ->whereHas('user', function($q) use($req){
        $q->where('name', 'LIKE', '%'. $req->search. '%');
      })
      ->limit(5)
      ->get();

    return response()->json(
      $members->map(function ($row) {
        return [
          'id' => $row->user['id'],
          'name' => $row->user['name'],
          'avatar' => $row->user['avatar'],
        ];
      })
    );
  }
}
