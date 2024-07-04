<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Role;

class SystemRolesPermissionsController extends Controller
{
  public function index() : Response {
    $roles = Role::query()
      ->with(['permissions', 'users' => function($q) {
        $q->limit(5);
      }])
      ->get();

    $permissions = Permission::query()
      ->orderBy('created_at', 'DESC')
      ->get();

    return Inertia::render(
      'dashboard/system-roles-permissions/(Index)',
      [
        'pageTitle' => 'Manage Roles & Permissions',
        'roles' => $roles,
        'permissions' => $permissions,
      ]
    );
  }

  public function update(Request $req, $permissionId) {
    $val = $req->validate([
      'type' => ['required'],
      'role_id' => ['required'],
      'value' => ['required']
    ]);

    $role = Role::where('id', $req->role_id)->where('name', '!=', 'admin')->first();

    if(!$role) {
      return to_route('dashboard.system-roles-permissions.index')->withErrors([
        'Admin Permissions' => 'You cannot modify admin permissions <img src="/assets/i see you.gif" class="mt-4">',
      ]);
    }

    if($req->value == true) {
      $role->attachPermission($permissionId);
    }
    else {
      $role->detachPermission($permissionId);
    }

    return to_route('dashboard.system-roles-permissions.index')->with('success', "Updated");
  }
}
