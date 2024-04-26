<?php
namespace App\Http\Controllers\dashboard;


use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ManageRolesPermissionsController extends Controller
{
  public function index() : Response {
    return Inertia::render('dashboard/ManageRolesPermissions', ['pageTitle' => 'Manage Roles & Permissions']);
  }
}
