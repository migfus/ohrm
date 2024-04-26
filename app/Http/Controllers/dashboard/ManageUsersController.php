<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ManageUsersController extends Controller
{
  public function index() : Response {
    $roles = Role::select('display_name', 'name')->orderBy('created_at', 'ASC')->get();
    return Inertia::render('dashboard/ManageUsers' , ['pageTitle' => 'Manage Users', 'roles' => $roles]);
  }
}
