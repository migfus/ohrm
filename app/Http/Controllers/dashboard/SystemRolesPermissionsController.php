<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;

class SystemRolesPermissionsController extends Controller
{
  public function index() : Response {
    $roles = Role::query()
      ->with(['permissions', 'users' => fn($q) => $q->limit(5)])
      ->get();

    $permissions = Permission::query()
      ->orderBy('created_at', 'desc')
      ->get();

    return Inertia::render(
      'dashboard/system-roles-permissions/(Index)',
      [
        'page_title' => 'Manage Roles & Permissions',
        'roles' => $roles,
        'permissions' => $permissions,
      ]
    );
  }

  public function update(Request $req, $permissionId) : RedirectResponse {
    $req->validate([
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
