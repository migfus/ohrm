<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AccountController extends Controller
{
  public function __construct() {
    Inertia::share('sidebar', true);
  }

  public function index() : Response {
    return Inertia::render('account/(Page)');
  }
}
