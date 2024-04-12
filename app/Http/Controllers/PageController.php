<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class PageController extends Controller
{
  public function index() : Response {
    return Inertia::render('Home/(Page)');
  }

}
