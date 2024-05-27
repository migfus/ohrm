<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
  public function about(Request $req) : Response {
    return Inertia::render('about/(Index)' , ['pageTitle' => 'About Us']);
  }
}

// MARK: hello
