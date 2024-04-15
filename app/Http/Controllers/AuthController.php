<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login() : Response {
    return Inertia::render('Auth/Login');
  }

  public function login_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'min:6'],
      'remember' => []
    ]);

    if(Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
      return to_route('home');
    }

    return to_route('login')->withErrors([
      'email' => 'Invalid Email & Password',
      'password' => 'Invalid Email & Password',
    ]);
  }

  public function forgot() : Response {
    return Inertia::render('Auth/Forgot');
  }
  public function forgot_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email']
    ]);

    return to_route('forgot');
  }
}
