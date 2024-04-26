<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class StatusController extends Controller
{
  public function index(Request $req) : Response {
    return Inertia::render('status/(Page)' , ['pageTitle' => 'Status']);
  }
}
