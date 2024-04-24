<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyGroupController extends Controller
{
  public function __construct() {
    Inertia::share('sidebar', true);
  }

  public function index() : Response {
    return Inertia::render('mygroups/(Page)');
  }
}
