<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\HeroIcon;
use App\Models\Role;
use App\Models\User;
use App\Models\GroupMember;
use App\Models\Group;


class ManageUsersController extends Controller
{
  // ✅
  // NOTE: ALL
  public function index(Request $req) : Response {
    $roles = Role::query()
      ->select('display_name', 'name', 'icon_name')
      ->with(['hero_icon' => function($q) {
        $q->select('content', 'name');
      }])
      ->orderBy('created_at', 'ASC')
      ->get();

    // dd($roles);

    $roles_processed = [
      [
        'name' => 'all',
        'display_name' => 'All',
        'hero_icon' => ['content' => HeroIcon::where('name', 'at-symbol_outline')->first()->content]
      ],
      ...$roles
    ];

    $users = null;
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
      'pageTitle' => 'Manage Users',
      'roles' => $roles_processed,
      'data' => $users,
      'filters' => [
        'page' => $req->page ?? null,
        'search' => $req->search ?? null,
        'type' => $req->type ?? null
      ]
    ]);
  }

  // NOTE: CREATE
  public function create() : Response {
    $roles = Role::query()
      ->select('display_name', 'id', 'name')
      ->orderBy('name', 'ASC')
      ->get();
    return Inertia::render('dashboard/manage-users/create/(Create)', ['pageTitle' => 'Create User', 'roles' => $roles]);
  }
  public function store(Request $req) {
    $val = $req->validate([
      'name' => ['required',],
      'email' => ['required', 'email', 'unique:users'],
      'password' => ['required', 'min:6'],
      'role' => ['required'],
      'avatar' => ['required'],
      'cover' => ['required'],
    ]);

    // return Team::where('name', 'system')->first();

    $user = User::create([
      'name' => $req->name,
      'email' => $req->email,
      'password' => Hash::make($req->password),
    ]);
    User::query()
      ->where('id', $user->id)
      ->update([
        'avatar' => $this->GUploadAvatar($req->avatar, "users/$user->id/avatar/"),
        'cover' => $this->GUploadAvatar($req->cover, "users/$user->id/cover/"),
      ]);

    $user->addRole($req->role, 'system');

    return to_route('dashboard.manage-users.index')->with('flash', ['success' => 'Successfuly Created.']);
  }

  // ✏️
  // NOTE: UPDATE
  public function edit(Request $req, $id) : Response {
    $roles = Role::query()
      ->select('id', 'display_name')
      ->get();
    $user = User::query()
      ->with(['roles', 'group_members.group', 'group_members.role.hero_icon'])
      ->where('id', $id)
      ->first();

    return Inertia::render('dashboard/manage-users/edit/(Edit)', [
      'pageTitle' => $user->name,
      'user' => $user,
      'roles' => $roles
    ]);
  }
  // ✏️
  public function update(Request $req, $id) : RedirectResponse {
    $req->validate([
      'type' => ['required']
    ]);

    switch($req->type) {
      case 'avatar':
        $this->UpdateAvatar($req, $id);
        break;
      case 'cover':
        $this->UpdateCover($req, $id);
        break;
      case 'basic':
        $this->UpdateBasic($req, $id);
        break;
      case 'update-role':
        $this->UpdateRole($req, $id);
        break;
      case 'remove-joined-group':
        $this->RemoveJoinedGroup($req, $id);
        break;
      default:
        return to_route('dashboard.manage-users.edit', ['manage_user' => $id])->withErrors(['type' => 'Invalid Type!']);
    }

    return to_route('dashboard.manage-users.edit', ['manage_user' => $id]);
  }
    // ✅
    private function UpdateBasic($req, $id): void {
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
    // ✅
    private function UpdateAvatar(Request $req, $id){
      $req->validate([
        'avatar' => ['required'],
      ]);

      if(User::find($id)->avatar == $req->avatar) {
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['avatar' => 'You can not upload the same image']);
      }

      User::find($id)->update(['avatar' => $this->GUploadAvatar($req->avatar, 'avatars/'.$id)]);
    }
    // ✅
    private function UpdateCover(Request $req, $id){
      $req->validate([
        'cover' => ['required'],
      ]);

      if(User::find($id)->cover == $req->cover) {
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['cover' => 'You can not upload the same image']);
      }

      User::find($id)->update(['cover' => $this->GUploadAvatar($req->cover, 'covers/'.$id)]);
    }
    // ✅
    private function UpdateRole(Request $req, $id) : void {
      $val = $req->validate([
        'userRoleId' => ['required', 'uuid']
      ]);

      User::where('id', $id)->first()->syncRoles([Role::where('id', $req->userRoleId)->first()]);
    }
    // ✏️
    private function RemoveJoinedGroup($req, $id){
      $val = $req->validate([
        'groupMemberId' => ['required', 'uuid']
      ]);

      // NOTE: Check if there's any available user's left as an admin role
      // REASON: We don't want a group without an admin user.
      $groupMember = GroupMember::where('id', $req->groupMemberId)->first();
      $group = Group::where('id', $groupMember->group_id)->withCount('group_members_admin_only')->first();

      if($group->group_members_admin_only_count <= 1) {
        return to_route('dashboard.manage-users.edit', ['manage_user' => $id])->withErrors(['group-member' => 'You cannot remove this member, this user is the only admin to this group. You need to assign a new admin in order to remove this user from the group.']);
      }
      GroupMember::where('id', $req->groupMemberId)->delete();
    }

  // NOTE: DELETE
  public function destroy($id) : RedirectResponse {
    if(User::find($id)->id == Auth::user()->id) {
      return to_route('dashboard.manage-user.show', ['id' => $id])->withErrors(['Invalid Permission' => 'You can not remove yourself']);
    }
    User::find($id)->delete();

    return to_route('dashboard.manage-users.index')->with('flash', ['success' => 'Successfuly Deleted.']);
  }
}
