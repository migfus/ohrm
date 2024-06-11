<?php
namespace App\Http\Controllers\dashboard;

use App\Models\HeroIcon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class ManageUsersController extends Controller
{


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

    return Inertia::render('dashboard/manage-users/(Index)' , [
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
    return Inertia::render('dashboard/manage-users/(Create)', ['pageTitle' => 'Create User', 'roles' => $roles]);
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

  // NOTE: UPDATE
  public function edit(Request $req, $id) : Response {
    $user = User::query()
      ->where('id', $id)
      ->with(['rolesTeams',
        'rolesTeamsHead' => function ($q) {
        $q->wherePivot('role_id', Role::where('name', 'head')->first()->id);
      }])
      ->first();

    return Inertia::render('dashboard/manage-users/(Edit)', ['pageTitle' => $user->name, 'user' => $user]);
  }
  public function update(Request $req, $id) : RedirectResponse {
    if($req->type == 'avatar') {
      $this->uploadAvatar($req, $id);
    }
    else if($req->type == 'cover') {
      $this->uploadCover($req, $id);
    }
    else {
      $req->validate([
        '_name' => ['required'],
        '_email' => ['required', 'email'],
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email,'.$id],
        'password' => ['required', 'min:8'],
      ]);

      User::find($id)
        ->when($req->_name != $req->name, function ($q) use ($req) {
          $q->update(['name' => $req->name]);
        })
        ->when($req->_email != $req->email, function ($q) use ($req) {
          $q->update(['email' => $req->email]);
        })
        ->when($req->password != '*******************', function ($q) use ($req) {
          $q->update(['password' => Hash::make($req->password)]);
        });
    }
    return to_route('dashboard.manage-user.show', ['id' => $id]);
  }

    private function uploadAvatar(Request $req, $id) {
      $req->validate([
        'avatar' => ['required'],
      ]);

      if(User::find($id)->avatar == $req->avatar) {
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['avatar' => 'You can not upload the same image']);
      }

      User::find($id)->update(['avatar' => $this->GUploadAvatar($req->avatar, 'avatars/'.$id)]);
    }

    private function uploadCover(Request $req, $id) {
      $req->validate([
        'cover' => ['required'],
      ]);

      if(User::find($id)->cover == $req->cover) {
        return to_route('dashboard.manage-user.show', ['id' => $id])
          ->withErrors(['cover' => 'You can not upload the same image']);
      }

      User::find($id)->update(['cover' => $this->GUploadAvatar($req->cover, 'covers/'.$id)]);
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
