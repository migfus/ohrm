<?php
namespace App\Http\Controllers\dashboard;

use App\Events\UpdateGroupPostsEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupRole;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskTemplate;
use App\Models\Post;

class ManageGroupsController extends Controller
{
  // FIXME: There's some group_member without users
  // REASON: During seeeder or mismatch ID.
  public function index(Request $req): Response {
    $val = $req->validate([
      'search' => [],
    ]);

    $groups = Group::query()
      ->select('description', 'name', 'id', 'avatar')
      ->when($req->search != '', function ($q) use($req) {
        $q->where("name", 'LIKE', "%$req->search%");
      })
      ->with([
        'group_members_admin_only.user' => fn($q) => $q->limit(5),
        'group_members_not_admin_only.user' => fn($q) => $q->limit(5)
      ])
      ->withCount(['group_members_admin_only', 'group_members_not_admin_only'])
      ->paginate(10);

    return Inertia::render(
      'dashboard/manage-groups/index/(Index)',
      [
        'pageTitle' => 'Manage Groups',
        'data' => $groups,
        'tabs' => [
          ['name' => 'All'],
        ],
        'filters' => [
          'search' => $req->search
        ],
      ]
    );
  }

  // NOTE: STORE
  public function store(Request $req): RedirectResponse {
    $val = $req->validate([
      'name' => ['required', 'unique:groups,name'],
      'description' => ['required'],
    ]);

    // DB::beginTransaction();

    // try {
      $group = Group::create([
        'name' => $req->name,
        'display_name' => $req->name,
        'description' => $req->description,
      ]);
      Group::query()
        ->where('id', $group->id)
        ->update([
          'avatar' => $this->GUploadAvatar('/assets/avatar_cover_default.jpg', "groups/$group->id/avatar/"),
          'cover' => $this->GUploadAvatar('/assets/cover_group_default.jpg', "groups/$group->id/cover/")
        ]);
      GroupMember::create([
        'user_id' => $req->user()->id,
        'group_id' => $group->id,
        'group_role_id' => GroupRole::where('name', 'admin')->first()->id,
      ]);

      return to_route('dashboard.manage-groups.edit', ['manage_group' => $group->id])->with('flash', ['success' => 'Successfuly Added']);
    // }
    // catch(\Exception $e) {
      // DB::rollBack();
      // return to_route('dashboard.manage-groups.create')->withErrors(['Unknown' => 'Something went wrong 😅']);
    // }
  }

  // ✅
  // NOTE: UPDATE
  public function edit(Request $req, $id): Response {



    // $tasks = Task::query()
    // ->where('task_template_id', $id)
    // ->with(['user_assigned.user', 'task_priority.hero_icon', 'task_status.hero_icon', 'task_template'])
    // ->limit(10)
    // ->orderBy('created_at', 'desc')
    // ->get();

    return Inertia::render('dashboard/manage-groups/edit/(Edit)', [
      'pageTitle'     => $this->editGetGroup($id)->name,
      'group'         => $this->editGetGroup($id),
      'groupMembers'  => $this->editGetGroupMembers($id),
      'taskTemplates' => $this->editGetTaskTemplates($id),
      'tasks'         => $this->editGetTasks($id),
      'groupRoles'    => $this->editGetGroupRoles(),
      'taskPriorities'=> TaskPriority::get(),
      'pinnedPosts'   => $this->editGetPinnedPost($id),
    ]);
  }
    private function editGetGroup($groupId) {
      return Group::where('id', $groupId)->first();
    }
    private function editGetGroupRoles() {
      return GroupRole::query()
        ->select('display_name', 'id', 'description', 'icon_name')
        ->with(['hero_icon' => function ($q) {
          $q->select('content', 'name');
        }])
        ->get();
    }
    private function editGetPinnedPost($groupId) {
      return Post::query()
      ->where('group_id', $groupId)
      ->where('is_pinned', 1)
      ->with(['user'])
      ->withCount('comments')
      ->orderBy('created_at', 'desc')
      ->limit(5)
      ->get();
    }
    private function editGetGroupMembers($id) {
      return GroupMember::query()
        ->where('group_id', $id)
        ->with(['user'])
        ->get();
    }
    private function editGetTaskTemplates($groupId) {
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
    private function editGetTasks($groupId) {
      Task::query()
        ->where('group_id', $groupId)
        ->with([
          'user_assigned.user',
          'task_priority.hero_icon',
          'task_status.hero_icon',
          'task_template'])
          ->orderBy('created_at', 'desc')
          ->limit(5);
    }
    private function editGetPosts(Request $req, $groupId) {
      return Post::query()
        ->where('group_id', $groupId)
        ->with(['user', 'comments.user'])
        ->withCount('comments')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }
  // ✏️
  public function update(Request $req, $id): RedirectResponse {
    switch($req->type) {
      // ✅
      case 'basic':
        $this->UpdateBasic($req, $id);
        break;
      // ✅
      case 'avatar':
        $this->UpdateAvatar($req, $id);
        break;
      // ✅
      case 'cover':
        $this->UpdateCover($req, $id);
        break;
      // ✅
      case 'add-member':
        $this->AddMember($req, $id);
        break;
      // ✅
      case 'remove-member':
        $this->RemoveMember($req, $id);
        break;
      // ✅
      case 'addTask':
        $this->AddTemplateTask($req, $id);
        break;
      // ✅
      case 'removeTask':
        $this->RemoveTemplateTask($req, $id);
        break;
      // ✏️
      case 'updateTask':
        $this->UpdateTemplateTask($req);
        break;
      default:
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->withErrors(['type' => 'Type value is missing']);
    }

    return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->with('success', "Updated");
  }
    // ✅
    private function UpdateBasic(Request $req, $id) : void {
      $val = $req->validate([
        'name' => ['required'],
        'description' => ['required'],
      ]);

      Group::where('id', $id)->update([
        'name' => $req->name,
        'description' => $req->description,
      ]);
    }
    // ✅
    private function UpdateAvatar(Request $req, $id) : void {
      $val = $req->validate([
        'avatar' => ['required']
      ]);

      Group::where('id', $id)->update([
        'avatar' => $this->GUploadAvatar($req->avatar, "groups/$id/avatar/"),
      ]);
    }
    // ✅
    private function UpdateCover(Request $req, $id) : void {
      $val = $req->validate([
        'cover' => ['required']
      ]);

      Group::where('id', $id)->update([
        'cover' => $this->GUploadAvatar($req->cover, "groups/$id/cover/")
      ]);
    }
    // ✅
    private function AddMember(Request $req, $id) : void {
      $val = $req->validate([
        'user_id' => ['required', 'uuid'],
        'roleId' => ['required', 'uuid']
      ]);

      GroupMember::create([
        'user_id' => $req->user_id,
        'group_role_id' => $req->roleId,
        'group_id' => $id,
      ]);
    }
    // ✅
    private function RemoveMember(Request $req, $id) {
      $val = $req->validate([
        'memberId' => ['required', 'uuid'],
      ]);

      // NOTE: Prevents no member in a group.
      if(Group::where('id', $id)->withCount('group_members')->first()->group_members_count > 1) {
        GroupMember::find($req->memberId)->delete();
      }
      else {
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->withErrors(['member' => 'At least 1 member should access the group.']);
      }
    }
    // ✏️
    private function UpdateTemplateTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
        'name' => ['required'],
      ]);

      Task::where('id', $req->taskId)->update([
        'name' => $req->name,
      ]);
    }
    // ✅
    private function RemoveTemplateTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
      ]);

      TaskTemplate::where('id', $req->taskId)->delete();
    }
    // ✅
    private function AddTemplateTask(Request $req, $id): void {
      $req->validate([
        'name' => ['required'],
        'priority_id' => ['required', 'uuid'],
        'description' => [''],
        'is_show' => ['required', 'boolean'],
      ]);

      TaskTemplate::create([
        'name' => $req->name,
        'description' => $req->description,
        'group_id' => $id,
        'default_task_priority_id' => $req->priority_id,
        'is_show' => $req->is_show ? true : false,
      ]);
    }

  // ✅
  // NOTE: Remove
  public function destroy($id) : RedirectResponse {
    Group::find($id)->delete();

    return to_route('dashboard.manage-groups.index')->with('flash', ['success' => 'Successfuly Removed']);
  }

  // ✅
  // FIXME: Need optimization, for now (6/13/2024) I don't want to touch the code as long it works.
  // NOTE: SHOW USERS BASED ON CURRENT/SELECTED GROUP (for security improvement)
  // REASON: We want to show up users list upon selecting admin/moderator/member but no duplicates.
  // FILTERING: We should look for [Group] first before we provide users, to prevent duplicates.
  // SECURITY CONCERN: Filters will work as well but vulnerable for duplicates and injections.
  public function UserComboBox(Request $req, $id) : JsonResponse {
    $dontIncludeUsers = [];
    $members = GroupMember::where('group_id', $id)->with('user')->get();
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
