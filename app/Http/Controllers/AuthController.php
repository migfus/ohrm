<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
  public function login() : Response {
    return Inertia::render('auth/Login' , ['page_title' => 'Login']);
  }

  public function loginSubmit(Request $req) : RedirectResponse {
    $val = $req->validate([
      'email'    => ['required', 'email'],
      'password' => ['required', 'min:6'],
      // 'remember' => []
    ]);

    if(Auth::attempt($val)) {
      $req->session()->regenerate();
      return to_route('dashboard.index')
        ->with('success', ['title' => 'Logged In Successfully!', 'content' => 'Welcome, '.Auth::user()->name]);
    }

    return to_route('login')
      ->withErrors([
        'email' => 'Invalid Email & Password',
        'password' => 'Invalid Email & Password',
      ]);
  }

  public function forgot() : Response {
    return Inertia::render('auth/Forgot' , ['page_title' => 'Forgot']);
  }
  public function forgotSubmit(Request $req) : RedirectResponse {
    $req->validate([
      'email' => ['required', 'email']
    ]);

    return to_route('forgot')
      ->with('success', ['title' => 'Email Link Sent!', 'content' => 'You can check your email for the password reset link.']);
  }

  public function logout(Request $req) : RedirectResponse {
    Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerate();

    return to_route('login')
      ->with('success', ['title' => 'Logged Out', 'content' => 'Logged Out Successfully!']);
  }
}
