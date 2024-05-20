<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Role;

class ManageRolesPermissionsController extends Controller
{
  public function index() : Response {
    $roles = \App\Models\Role::query()
      ->with(['permissions', 'users' => function($q) {
        $q->limit(5);
      }])
      ->get();

    $permissions = \App\Models\Permission::query()
      ->orderBy('created_at', 'DESC')
      ->get();

    $teams = \App\Models\Team::query()
      ->with(['users.roles'])
      ->orderBy('created_at', 'DESC')
      ->get();

    return Inertia::render(
      'dashboard/manage-roles-permissions/(Page)',
      [
        'pageTitle' => 'Manage Roles & Permissions',
        'roles' => $roles,
        'permissions' => $permissions,
        'teams' => $teams
      ]
    );
  }

  public function create(Request $req) {
    $val = $req->validate([
      'type' => ['required'],
      'role_id' => ['required'],
      'permission_id' => ['required'],
      'value' => ['required']
    ]);

    $role = Role::where('id', $req->role_id)->where('name', '!=', 'admin')->first();

    if(!$role) {
      return to_route('dashboard.manage-roles-permissions')->withErrors([
        'Admin Permissions' => 'You cannot modify admin permissions <img src="/assets/i see you.gif" class="mt-4">',
      ]);
    }

    if($req->value == true) {
      $role->attachPermission($req->permission_id);
    }
    else {
      $role->detachPermission($req->permission_id);
    }

    return to_route('dashboard.manage-roles-permissions');
  }
}
