<?php
namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupRole;
use App\Models\GroupTaskActivity;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskTemplate;


class ManageGroupsController extends Controller
{
  // FIXME: There's some group_member without users
  // REASON: During seeeder or mismatch ID.
  public function index(Request $req): Response {
    $req->validate(['search' => []]);

    $groups = Group::query()
      ->select('description', 'name', 'id', 'avatar')
      ->when($req->search != '', function ($q) use($req) {
        $q->where("name", 'LIKE', "%$req->search%");
      })
      ->orderBy('created_at', 'desc')
      ->paginate(20);

    return Inertia::render(
      'dashboard/manage-groups/index/(Index)', [
        'page_title' => 'Manage Groups',
        'data' => $groups,
        'tabs' => [
          ['name' => 'All'],
        ],
        'filters' => [
          'search' => $req->search
        ],
    ]);
  }

  // NOTE: STORE
  public function store(Request $req): RedirectResponse {
    $req->validate([
      'name'        => ['required', 'unique:groups,name'],
      'description' => ['required'],
    ]);

    DB::beginTransaction();
    try {
      $group = Group::create([
        'name' => $req->name,
        'display_name' => $req->name,
        'description' => $req->description,
      ]);

      GroupTaskActivity::create([
        'group_id' => $group->id,
        'log_at' => Carbon::now()->subDays(1),
        'count' => 0,
      ]);

      Group::query()
        ->where('id', $group->id)
        ->update([
          'avatar' => $this->gUploadAvatar('/assets/avatar_cover_default.jpg', "groups/$group->id/avatar/"),
          'cover'  => $this->gUploadAvatar('/assets/cover_group_default.jpg', "groups/$group->id/cover/")
        ]);

      GroupMember::create([
        'user_id'       => $req->user()->id,
        'group_id'      => $group->id,
        'group_role_id' => GroupRole::where('name', 'admin')->first()->id,
      ]);

      return to_route('dashboard.manage-groups.edit', ['manage_group' => $group->id])->with('flash', ['success' => 'Successfuly Added']);
    }
    catch(\Exception $e) {
      DB::rollBack();
      return to_route('dashboard.manage-groups.create')->withErrors(['Unknown' => 'Something went wrong 😅']);
    }
  }

  // NOTE: UPDATE
  public function edit($id): Response {
    $group = $this->editGetGroup($id);
    return Inertia::render('dashboard/manage-groups/edit/(Edit)', [
      'page_title'     => $group->name,
      'group'          => $group,
      'group_members'  => $this->editGetGroupMembers($id),
      'task_templates' => $this->editGetTaskTemplates($id),
      'tasks'          => $this->editGetTasks($id),
      'group_roles'    => $this->editGetGroupRoles(),
      'task_priorities'=> TaskPriority::with('hero_icon')->get(),
      'group_task_activities' => $this->editGetGroupTaskActivities($id),
    ]);
  }
    private function editGetGroup($groupId) : Group {
      return Group::where('id', $groupId)->first();
    }
    private function editGetGroupRoles() : Collection {
      return GroupRole::query()
        ->select('display_name', 'id', 'description', 'icon_name')
        ->with(['hero_icon' => function ($q) {
          $q->select('content', 'name');
        }])
        ->get();
    }
    private function editGetGroupMembers($id) : Collection {
      return GroupMember::query()
        ->where('group_id', $id)
        ->with(['user'])
        ->get();
    }
    private function editGetTaskTemplates($groupId) : Collection {
      return TaskTemplate::query()
        ->where('group_id', $groupId)
        ->with([
          'task_priority.hero_icon',
          'task_user_access' => function ($q) {
            $q->with('user')->limit(5);
          }
        ])
        ->withCount('task_user_access')
        ->get();
    }
    private function editGetTasks($groupId) : Collection {
      return Task::query()
        ->where('group_id', $groupId)
        ->with([
          'user_assigned.user',
          'task_priority.hero_icon',
          'task_status.hero_icon',
          'task_template'
        ])
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get();
    }
    private function editGetGroupTaskActivities($group_id) : Object {
      return GroupTaskActivity::query()
        ->where('group_id', $group_id)
        ->where('log_at', '>=', Carbon::now()->subYears(1))
        ->orderBy('log_at', 'desc')
        ->get()
        ->map(fn($r) => ['date' => $r->log_at, 'count' => $r->count]);
    }

  public function update(Request $req, $id): RedirectResponse {
    $success_message = ['title' => 'Group Updated', 'content' => 'Group details updated successfully'];

    switch($req->type) {
      // ✅
      case 'basic':
        $this->updateBasic($req, $id);
        break;
      // ✅
      case 'avatar':
        $this->updateAvatar($req, $id);
        break;
      // ✅
      case 'cover':
        $this->updateCover($req, $id);
        $success_message = ['title' => "Groups cover has changed", 'content' => 'Successfully changed to new cover'];
        break;
      // ✅
      case 'add-member':
        $this->addMember($req, $id);
        $success_message = ['title' => 'New Member Added', 'content' => 'Successfully added new member'];
        break;
      // ✅
      case 'remove-member':
        $this->removeMember($req, $id);
        $success_message = ['title' => 'Member Removed', 'content' => 'Successfully removed member'];
        break;
      // ✅
      case 'addTask':
        $this->addTemplateTask($req, $id);
        $success_message = ['title' => 'New Template Task Added', 'content' => 'Successfully added new task template'];
        break;
      // ✅
      case 'removeTask':
        $this->removeTemplateTask($req, $id);
        $success_message = ['title' => 'Task Template Removed', 'content' => 'Successfully removed the task template'];
        break;
      // ✏️
      case 'updateTask':
        $this->updateTemplateTask($req);
        break;
      default:
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])
          ->withErrors(['type' => 'Type value is missing']);
    }

    return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])
      ->with('success', $success_message);
  }
    // ✅
    private function updateBasic(Request $req, $id) : void {
      $req->validate([
        'name'        => ['required'],
        'description' => ['required'],
        'is_visible'  => ['required', 'boolean'],
      ]);

      Group::query()
        ->where('id', $id)
        ->update([
          'name'        => $req->name,
          'description' => $req->description,
          'is_visible'  => $req->is_visible
        ]);
    }
    // ✅
    private function updateAvatar(Request $req, $id) : void {
      $req->validate([
        'avatar' => ['required']
      ]);

      Group::where('id', $id)->update([
        'avatar' => $this->gUploadAvatar($req->avatar, "groups/$id/avatar/"),
      ]);
    }
    // ✅
    private function updateCover(Request $req, $id) : void {
      $req->validate([
        'cover' => ['required']
      ]);

      Group::where('id', $id)->update([
        'cover' => $this->gUploadAvatar($req->cover, "groups/$id/cover/")
      ]);
    }
    // ✅
    private function addMember(Request $req, $id) : void {
      $req->validate([
        'user_id' => ['required', 'uuid'],
        'roleId'  => ['required', 'uuid']
      ]);

      $removed_group_member = GroupMember::query()
        ->where('user_id', $req->user_id)
        ->where('group_id', $id)
        ->where('group_role_id', GroupRole::where('name', 'removed')->first()->id)
        ->first();

      if($removed_group_member) {
        GroupMember::find($removed_group_member->id)->update([
          'group_role_id' => $req->roleId,
        ]);
      }
      else {
        GroupMember::create([
          'user_id'       => $req->user_id,
          'group_role_id' => $req->roleId,
          'group_id'      => $id,
        ]);
      }
    }
    // ✅
    private function removeMember(Request $req, $id) : ?RedirectResponse {
      $req->validate([
        'member_id' => ['required', 'uuid'],
      ]);

      // NOTE: Prevents no member in a group.
      if(Group::where('id', $id)->withCount('group_members')->first()->group_members_count > 1)
        GroupMember::find($req->member_id)->update([
          'group_role_id' => GroupRole::where('name', 'removed')->first()->id,
        ]);
      else
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])
          ->withErrors(['member' => 'At least 1 member should access the group.']);

    }
    // ✏️
    private function updateTemplateTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
        'name'   => ['required'],
      ]);

      Task::where('id', $req->taskId)->update([
        'name' => $req->name,
      ]);
    }
    // ✅
    private function removeTemplateTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
      ]);

      TaskTemplate::query()
        ->where('id', $req->taskId)
        ->delete();
    }
    // ✅
    private function addTemplateTask(Request $req, $id): void {
      $req->validate([
        'name'        => ['required'],
        'priority_id' => ['required', 'uuid'],
        'message' => [''],
        'is_show'     => ['required', 'boolean'],
      ]);

      TaskTemplate::create([
        'name'        => $req->name,
        'message'     => $req->message,
        'group_id'    => $id,
        'default_task_priority_id' => $req->priority_id,
        'is_show'     => $req->is_show ? true : false,
      ]);
    }

  // ✅
  // NOTE: Remove
  public function destroy($id) : RedirectResponse {
    Group::query()
      ->find($id)
      ->delete();

    return to_route('dashboard.manage-groups.index')
      ->with('success', ['title' => 'Removed', 'content' => 'Successfuly Removed']);
  }

  // ✅
  // FIXME: Need optimization, for now (6/13/2024) I don't want to touch the code as long it works.
  // NOTE: SHOW USERS BASED ON CURRENT/SELECTED GROUP (for security improvement)
  // REASON: We want to show up users list upon selecting admin/moderator/member but no duplicates.
  // FILTERING: We should look for [Group] first before we provide users, to prevent duplicates.
  // SECURITY CONCERN: Filters will work as well but vulnerable for duplicates and injections.
  public function userComboBox(Request $req, $id) : JsonResponse {
    $members = GroupMember::query()
      ->where('group_id', $id)
      ->whereNot('group_role_id', GroupRole::where('name', 'removed')->first()->id)
      ->with('user')
      ->get();

    $dontIncludeUsers = [];
    foreach($members as $row) {
      $dontIncludeUsers[]  = $row->user['id'];
    }

    return response()->json(
      User::query()
        ->select('name', 'id', 'avatar')
        ->whereNotIn('id', $dontIncludeUsers)
        ->where('name', 'LIKE', '%'. $req->search. '%')
        ->orderBy('name', 'ASC')
        ->limit(5)
        ->get()
    );
  }
}
