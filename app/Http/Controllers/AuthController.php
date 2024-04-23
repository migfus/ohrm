<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $req) : Response {
    return Inertia::render('Auth/Login');
  }

  public function login_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'min:6'],
      // 'remember' => []
    ]);

    if(Auth::attempt($val)) {
      $req->session()->regenerate();
      // dd(Auth::id());
      // dd(Auth::user()->only('email', 'name')); // returns auth data. After redirect it will returns null.
      return to_route('dashboard.index')->with('message', 'Successfuly Login');
    }

    return to_route('login')->withErrors([
      'email' => 'Invalid Email & Password',
      'password' => 'Invalid Email & Password',
    ]);
  }

  public function forgot(Request $req) : Response {
    return Inertia::render('Auth/Forgot');
  }
  public function forgot_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email']
    ]);

    return to_route('forgot');
  }
}
