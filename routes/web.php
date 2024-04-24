<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyGroupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;


// MARK: PAGES
Route::get('/', [PageController::class, 'index'])->name('home');

Route::resource('/status', StatusController::class)->only(['index']);
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// MARK: AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware(['guest']);
Route::post('/login', [AuthController::class, 'login_submit'])->name('login.submit');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/forgot', [AuthController::class, 'forgot_submit'])->name('forgot.submit');


Route::middleware(['auth'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/my-groups', [MyGroupController::class, 'index'])->name('my-groups');
  Route::get('/account', [AccountController::class, 'index'])->name('account');

  Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
  });
});

