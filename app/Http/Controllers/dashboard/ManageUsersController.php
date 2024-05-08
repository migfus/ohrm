<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ManageUsersController extends Controller
{
  public function index(Request $req) : Response {
    $roles = Role::select('display_name', 'name')->orderBy('created_at', 'ASC')->get();
    $roles_processed = [['name' => 'all', 'display_name' => 'All'], ...$roles];

    $users = null;
    $type = $req->type ?? 'all';

    if($type == 'all') {
      $users = User::query()
      ->when($req->search, function ($q) use ($req) {
        $q->where('name', 'LIKE', '%' . $req->search . '%');
        $q->orWhere('email', 'LIKE', '%' . $req->search . '%');
      })
      ->orderBy('name', 'ASC')
      ->paginate(10);
    }
    else {
      $users = User::query()
      ->when($req->search, function ($q) use ($req) {
        $q->where('name', 'LIKE', '%' . $req->search . '%');
        $q->orWhere('email', 'LIKE', '%' . $req->search . '%');
      })
      ->whereHasRole($req->type, 'default') // NOTE Default Team (the system team)
      ->orderBy('name', 'ASC')
      ->paginate(10);
    }

    return Inertia::render('dashboard/manage-users/(Page)' , [
      'pageTitle' => 'Manage Users',
      'roles' => $roles_processed,
      'data' => $users,
    ]);
  }

  public function show(Request $req, $id) : Response {
    $user = User::where('id', $id)->first();

    return Inertia::render('dashboard/manage-users/(Show)', ['pageTitle' => $user->name]);
  }
}
