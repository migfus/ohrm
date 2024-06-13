<?php
namespace App\Http\Controllers\dashboard;

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
        'group_members_member_only.user' => fn($q) => $q->limit(5)
      ])
      ->withCount(['group_members_admin_only', 'group_members_member_only'])
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
  public function create(Request $req): Response  {
    $users = User::query()
      ->whereNot('id', $req->user()->id)
      ->select('name', 'id', 'avatar')
      ->get();

    return Inertia::render(
      'dashboard/manage-groups/create/(Create)',
      [
        'pageTitle' => 'Create Group',
        'users' => $users
      ]
    );
  }
  public function store(Request $req): RedirectResponse {
    $val = $req->validate([
      'name' => ['required', 'unique:teams,name'],
      'description' => ['required'],
      'avatar' => ['required'],
      'cover' => ['required'],
      'invitedUsers.*' => ['required'],
      'tasks.*' => ['required'],
    ]);

    $heads = array_filter($req->invitedUsers, function($row) {
      if(isset($row['type'])) {
        if($row['type'] == 'head')
          return true;
      }
      return false;
    });
    $staffs = array_filter($req->invitedUsers, function($row) {
      if(isset($row['type'])) {
        if($row['type'] =='member')
          return true;
      }
      return false;
    });


    // DB::beginTransaction();

    // try {
      $team = Group::create([
        'name' => $req->name,
        'display_name' => $req->name,
        'description' => $req->description,
      ]);
      Group::query()
        ->where('id', $team->id)
        ->update([
          'avatar' => $this->GUploadAvatar($req->avatar, "groups/$team->id/avatar/"),
          'cover' => $this->GUploadAvatar($req->cover, "groups/$team->id/cover/")
        ]);

      // NOTE: ADD ROLE to head
      foreach($heads as $head) {
        User::find($head['id'])->addRole('head', $team->name);
      }
      // NOTE: Invited User as Staff in group;
      foreach($staffs as $staff) {
        User::find($staff['id'])->addRole('staff', $team->name);
      }

      foreach($req->tasks as $task) {
        Task::create([
          'team_id' => $team->id,
          'name' => $task['name'],
        ]);
      }

      return to_route('dashboard.manage-groups.edit', ['manage_group' => $team->id])->with('flash', ['success' => 'Successfuly Added']);
    // }
    // catch(\Exception $e) {
      // DB::rollBack();
      // return to_route('dashboard.manage-groups.create')->withErrors(['Unknown' => 'Something went wrong 😅']);
    // }
  }

  // ✅
  // NOTE: UPDATE
  public function edit(Request $req, $id): Response {
    $data = Group::query()
      ->select('id', 'name', 'avatar', 'cover', 'description')
      ->where('id', $id)
      ->with([
        'group_members_admin_only.user',
        'group_members_member_only.user',
        'group_members_moderator_only.user',
      ])
      ->first();

    $roles = GroupRole::query()->get();

    return Inertia::render('dashboard/manage-groups/edit/(Edit)', [
      'pageTitle' => $data->display_name,
      'data' => $data,
      'group_roles' => $roles,
    ]);
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
      // ✏️
      case 'add-member':
        $this->AddMember($req, $id);
        break;
      // ✅
      case 'remove-member':
        $this->RemoveMember($req, $id);
        break;

      case 'addTask':
        $this->AddTask($req, $id);
        break;
      case 'removeTask':
        $this->RemoveTask($req, $id);
        break;
      case 'updateTask':
        $this->updateTask($req);
        break;
      case'removeTask':
      default:
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->withErrors(['type' => 'Type value is missing']);
    }

    return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->with('flash', ['success' => 'Successfuly Updated']);
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
        'user_id' => ['required'],
        'as' => ['required'] // NOTE: admin/moderator/member
      ]);

      switch($req->as) {
        case 'admin':
          GroupMember::create([
            'user_id' => $req->user_id,
            'group_role_id' => GroupRole::where('name', 'admin')->first()->id,
            'group_id' => $id,
          ]);
          break;
        case 'moderator':
          GroupMember::create([
            'user_id' => $req->user_id,
            'group_role_id' => GroupRole::where('name', 'moderator')->first()->id,
            'group_id' => $id,
          ]);
          break;
        default:
          GroupMember::create([
            'user_id' => $req->user_id,
            'group_role_id' => GroupRole::where('name', 'member')->first()->id,
            'group_id' => $id,
          ]);
      }
    }
    // ✅
    private function RemoveMember(Request $req, $id) {
      $val = $req->validate([
        'memberId' => ['required', 'uuid'],
      ]);

      // NOTE: Prevents no member in a group.
      if(Group::where('id', $id)->withCount('group_members_admin_only')->first()->group_members_admin_only_count > 1) {
        GroupMember::find($req->memberId)->delete();
      }
      else {
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->withErrors(['member' => 'At least 1 member should access the group.']);
      }
    }

    private function updateTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
        'name' => ['required'],
      ]);

      Task::where('id', $req->taskId)->update([
        'name' => $req->name,
      ]);
    }
    private function RemoveTask(Request $req): void {
      $req->validate([
        'taskId' => ['required', 'uuid'],
      ]);

      Task::where('id', $req->taskId)->delete();
    }
    private function AddTask(Request $req, $id): void {
      $req->validate([
        'name' => ['required'],
      ]);

      Task::create([
        'team_id' => $id,
        'name' => $req->name,
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
