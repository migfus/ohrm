<?php
namespace App\Http\Controllers\dashboard;


use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Models\Role;

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
}
