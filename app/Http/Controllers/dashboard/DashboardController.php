<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('dashboard/(Index)', [
      'page_title' => 'Dashboard'
    ]);
  }

  public function account(Request $req) : Response {
    return Inertia::render('dashboard/Account' , [
      'page_title' => 'Account'
    ]);
  }
}
