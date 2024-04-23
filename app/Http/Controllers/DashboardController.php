<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('/dashboard/(Page)');
  }

  public function account(Request $req) : Response {
    return Inertia::render('/dashboard/Account');
  }
}
