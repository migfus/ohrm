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
      return Inertia::render('home/(Page)', ['auth' => Auth::user()]);
    }
    return Inertia::render('home/(Page)');
  }


  public function contact(Request $req) : Response {
    return Inertia::render('contact/(Page)');
  }
}

// MARK: hello
