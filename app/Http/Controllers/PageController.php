<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
  public function index(Request $req) : Response {
    if(auth()->check()); {
      return Inertia::render('home/(Page)', ['pageTitle' => 'Home', 'auth' => Auth::user()]);
    }
    return Inertia::render('home/(Page)' , ['pageTitle' => 'Home']);
  }


  public function about(Request $req) : Response {
    return Inertia::render('about/(Page)' , ['pageTitle' => 'About Us']);
  }
}

// MARK: hello
