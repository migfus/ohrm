<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
  public function about() : Response {
    return Inertia::render('about/(Index)' , ['page_title' => 'About Us']);
  }
}
