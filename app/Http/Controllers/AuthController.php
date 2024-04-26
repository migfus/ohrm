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
    return Inertia::render('auth/Login' , ['pageTitle' => 'Login']);
  }

  public function login_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'min:6'],
      // 'remember' => []
    ]);

    if(Auth::attempt($val)) {
      $req->session()->regenerate();
      return to_route('dashboard.index');
    }

    return to_route('login')->withErrors([
      'email' => 'Invalid Email & Password',
      'password' => 'Invalid Email & Password',
    ]);
  }

  public function forgot(Request $req) : Response {
    return Inertia::render('auth/Forgot' , ['pageTitle' => 'Forgot']);
  }
  public function forgot_submit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email' => ['required', 'email']
    ]);

    return to_route('forgot');
  }

  public function logout(Request $req) : RedirectResponse {
    Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerate();

    return to_route('login');
  }
}
