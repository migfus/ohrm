<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ManageUsersController extends Controller
{
  public function index() : Response {
    return Inertia::render('dashboard/ManageUsers' , ['pageTitle' => 'Manage Users']);
  }
}
