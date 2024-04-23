<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  // MARK: PAGES
  Route::get('/', [PageController::class, 'index'])->name('home');

  Route::resource('/status', StatusController::class)->only(['index']);
  Route::get('/contact', [PageController::class, 'contact'])->name('contact');

  // MARK: AUTH
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login', [AuthController::class, 'login_submit'])->name('login.submit');
  Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
  Route::post('/forgot', [AuthController::class, 'forgot_submit'])->name('forgot.submit');
});


Route::middleware(['auth'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/account', [DashboardController::class, 'account'])->name('account');
  });
});

