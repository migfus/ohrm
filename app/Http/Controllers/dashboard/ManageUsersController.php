<?php
namespace App\Http\Controllers\dashboard;

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
    $roles = Role::select('display_name', 'name')->orderBy('created_at', 'ASC')->get();
    $roles_processed = [['name' => 'all', 'display_name' => 'All'], ...$roles];

    $users = null;
    $type = $req->type ?? 'all';

    $users = User::query()
      ->when($req->search, function ($q) use ($req) {
        $q->where('name', 'LIKE', '%' . $req->search . '%');
        $q->orWhere('email', 'LIKE', '%' . $req->search . '%');
      })
      ->when($type != 'all', function ($q) use($type) {
        $q->whereHasRole($type, 'system');
      })
      ->with(['rolesTeams' => function ($q) {
        $q->orderBy('created_at', 'ASC');
      }])
      ->orderBy('name', 'ASC')
      ->paginate(10);

    return Inertia::render('dashboard/manage-users/(Page)' , [
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

  // NOTE: INFO
  public function show(Request $req, $id) : Response {
    $user = User::query()
      ->where('id', $id)
      ->with(['rolesTeams',
        'rolesTeamsHead' => function ($q) {
        $q->wherePivot('role_id', Role::where('name', 'head')->first()->id);
      }])
      ->first();

    return Inertia::render('dashboard/manage-users/(Show)', ['pageTitle' => $user->name, 'user' => $user]);
  }

  // NOTE: CREATE
  public function create() : Response {
    return Inertia::render('dashboard/manage-users/(Create)', ['pageTitle' => 'Create User']);
  }
  public function store(Request $req): RedirectResponse {
    return to_route('dashboard.manage-users.index')->with('flash', ['success' => 'Successfuly Created.']);
  }

  // NOTE: UPDATE
  public function edit() : Response {
    return Inertia::render('dashboard/manage-users/(Edit)', ['pageTitle' => 'Update User']);
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
