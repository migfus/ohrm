<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('dashboard/(Page)', ['pageTitle' => 'Dashboard']);
  }

  public function account(Request $req) : Response {
    return Inertia::render('dashboard/Account' , ['pageTitle' => 'Account']);
  }
}
