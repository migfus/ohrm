<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

use App\Models\HeroIcon;
use App\Models\Role;
use App\Models\User;
use App\Models\GroupMember;
use App\Models\Group;
use App\Models\Task;
use App\Models\UserTaskActivity;

class ManageUsersController extends Controller
{
  // NOTE: ALL
  public function index(Request $req) : Response {
    $roles = Role::query()
      ->select('display_name', 'name', 'icon_name', 'id')
      ->with(['hero_icon' => function($q) {
        $q->select('content', 'name');
      }])
      ->orderBy('created_at', 'ASC')
      ->get();

    $roles_processed = [[
        'name' => 'all',
        'display_name' => 'All',
        'hero_icon' => [
          'content' => HeroIcon::where('name', 'at-symbol_micro')->first()->content
        ]
      ], ...$roles
    ];

    $type = $req->type ?? 'all';

    $users = User::query()
      ->when($req->search != '', function ($q) use ($req) {
        $q->where('name', 'LIKE', '%' . $req->search . '%');
        $q->orWhere('email', 'LIKE', '%' . $req->search . '%');
      })
      ->when($type != 'all', function ($q) use($type) {
        $q->whereHasRole($type);
      })
      ->with(['group_members.role', 'group_members.group'])
      ->orderBy('name', 'ASC')
      ->paginate(10);

    return Inertia::render('dashboard/manage-users/index/(Index)' , [
      'page_title' => 'Manage Users',
      'roles' => $roles_processed,
      'user_roles' => $roles,
      'data' => $users,
      'filters' => [
        'page' => $req->page ?? null,
        'search' => $req->search ?? null,
        'type' => $req->type ?? null
      ]
    ]);
  }

  // NOTE: CREATE
  public function store(Request $req) : RedirectResponse {
    $req->validate([
      'name'     => ['required',],
      'email'    => ['required', 'email', 'unique:users'],
      'password' => ['required', 'min:6'],
      'roleId'   => ['required', 'uuid'],
    ]);

    $user = User::create([
      'name'     => $req->name,
      'email'    => $req->email,
      'password' => Hash::make($req->password),
    ]);
    User::query()
      ->where('id', $user->id)
      ->update([
        'avatar' => $this->gUploadAvatar('/assets/avatar_default.png', "users/$user->id/avatar/"),
        'cover'  => $this->gUploadAvatar('/assets/cover_group_default.jpg', "users/$user->id/cover/"),
      ]);

    $user->addRole(Role::where('id', $req->roleId)->first(), 'system');
    UserTaskActivity::create([
      'user_id' => $user->id,
      'count' => 0,
      'log_at' => Carbon::now()->subDays(1)
    ]);

    return to_route('dashboard.manage-users.index')
      ->with('success', ['title' => 'Created', 'content' => 'User created successfully.']);
  }

  // NOTE: UPDATE
  public function edit($id) : Response {
    $roles = Role::query()
      ->select('id', 'display_name')
      ->get();
    $user = User::query()
      ->with([
        'roles',
        'group_members.group',
        'group_members.role.hero_icon'
      ])
      ->where('id', $id)
      ->first();

    $task_activity = UserTaskActivity::query()
      ->where('user_id', $user->id)
      ->where('created_at', '>=', Carbon::now()->subYears(1))
      ->orderBy('created_at', 'DESC')
      ->get()
      ->map(fn($r) => [
        'date' => $r->log_at,
        'count' => $r->count
      ]);
    $task_count_now = Task::query()
      ->where('user_assigned_id', $user->id)
      ->where('created_at', Carbon::now())
      ->count();

    return Inertia::render('dashboard/manage-users/edit/(Edit)', [
      'page_title' => $user->name,
      'user' => $user,
      'roles' => $roles,
      'task_activity' => $task_activity,
      'task_count_now' => $task_count_now,
    ]);
  }

  public function update(Request $req, $id) : RedirectResponse {
    $req->validate([
      'type' => ['required']
    ]);

    switch($req->type) {
      case 'avatar':
        $this->updateAvatar($req, $id); break;
      case 'cover':
        $this->updateCover($req, $id); break;
      case 'basic':
        $this->updateBasic($req, $id); break;
      case 'update-role':
        $this->updateRole($req, $id); break;
      case 'remove-joined-group':
        $this->removeJoinedGroup($req, $id); break;
      default:
        return to_route('dashboard.manage-users.edit', ['manage_user' => $id])
          ->withErrors(['type' => 'Invalid Type!']);
    }

    return to_route('dashboard.manage-users.edit', ['manage_user' => $id])->with('success', "Updated");
  }
    private function updateBasic($req, $id): void {
      $req->validate([
        '_name' => ['required'],
        '_email' => ['required', 'email'],
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email,'.$id],
        'password' => ['required', 'min:8'],
      ]);

      User::where('id', $id)
        ->when($req->_name != $req->name, function ($q) use ($req) {
          $q->update(['name' => $req->name]);
        })
        ->when($req->_email != $req->email, function ($q) use ($req) {
          $q->update(['email' => $req->email]);
        })
        ->when($req->password != '●●●●●●●●', function ($q) use ($req) {
          $q->update(['password' => Hash::make($req->password)]);
        });
    }
    private function updateAvatar(Request $req, $id) : RedirectResponse {
      $req->validate([
        'avatar' => ['required']
      ]);

      if(User::find($id)->avatar == $req->avatar)
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['avatar' => 'You can not upload the same image']);

      User::query()
        ->find($id)
        ->update([
          'avatar' => $this->GUploadAvatar($req->avatar, 'avatars/'.$id)
        ]);
    }
    private function updateCover(Request $req, $id) : RedirectResponse  {
      $req->validate([
        'cover' => ['required'],
      ]);

      if(User::find($id)->cover == $req->cover)
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['cover' => 'You can not upload the same image']);

      User::query()
        ->find($id)
        ->update([
          'cover' => $this->GUploadAvatar($req->cover, 'covers/'.$id)
        ]);
    }
    private function updateRole(Request $req, $id) : void {
      $req->validate([
        'user_role_id' => ['required', 'uuid']
      ]);

      User::query()
        ->where('id', $id)
        ->first()
        ->syncRoles([
          Role::query()
            ->where('id', $req->user_role_id)
            ->first()
        ]);
    }
    private function removeJoinedGroup($req, $id) : RedirectResponse {
      $req->validate([
        'group_member_id' => ['required', 'uuid']
      ]);

      // NOTE: Check if there's any available user's left as an admin role
      // REASON: We don't want a group without an admin user.
      $group_member = GroupMember::query()
        ->where('id', $req->group_member_id)
        ->first();
      $group = Group::where('id', $group_member->group_id)
        ->withCount('group_members_admin_only')
        ->first();

      if($group->group_members_admin_only_count <= 1) {
        return to_route('dashboard.manage-users.edit', ['manage_user' => $id])
          ->withErrors([
            'group-member' =>
              'You cannot remove this member, this user is the only admin to this group. You need to assign a new admin in order to remove this user from the group.'
          ]);
      }
      GroupMember::where('id', $req->groupMemberId)->delete();
    }

  // NOTE: DELETE
  public function destroy($id) : RedirectResponse {
    if(User::find($id)->id == Auth::user()->id)
      return to_route('dashboard.manage-user.show', ['id' => $id])
        ->withErrors(['Invalid Permission' => 'You can not remove yourself']);

    User::find($id)->delete();

    return to_route('dashboard.manage-users.index')
      ->with('success', ['title' => 'Deleted', 'content' => 'Successfuly Deleted.']);
  }
}
