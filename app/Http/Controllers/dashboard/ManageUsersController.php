<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rule;

class ManageUsersController extends Controller
{
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
    ]);
  }

  public function show(Request $req, $id) : Response {
    $user = User::find($id);

    return Inertia::render('dashboard/manage-users/(Show)', ['pageTitle' => $user->name, 'user' => $user]);
  }

  public function update(Request $req, $id) {
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
        $q->update(['email' => $req->email]);
      });

    return to_route('dashboard.manage-user.show', ['id' => $id]);
  }

}
