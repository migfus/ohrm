<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
  public function index() : Response {
    if(auth()->check()); {
      return Inertia::render('Home/(Page)', ['auth' => Auth::user()]);
    }
    return Inertia::render('Home/(Page)');
  }

}

// MARK: hello
