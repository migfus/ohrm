<?php

use App\Http\Controllers\dashboard\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\JoinedGroupsController;
use App\Http\Controllers\dashboard\ManageGroupsController;
use App\Http\Controllers\dashboard\ManageRolesPermissionsController;
use App\Http\Controllers\dashboard\ManageUsersController;
use App\Http\Controllers\dashboard\MyGroupsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\dashboard\SystemSettingsController;
use Illuminate\Support\Facades\Route;

// NOTE: PAGES
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::resource('/status', StatusController::class)->only(['index']);

// NOTE: AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware(['guest']);
Route::post('/login', [AuthController::class, 'login_submit'])->name('login.submit');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/forgot', [AuthController::class, 'forgot_submit'])->name('forgot.submit');

Route::middleware(['auth'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::resource('/dashboard', DashboardController::class)->only(['index']);
  Route::resource('/my-groups', MyGroupsController::class)->only(['index']);


  Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {
    // NOTE: Dashboard
    Route::resource('/', DashboardController::class)->only(['index']);
    Route::resource('/my-groups', MyGroupsController::class)->only(['index']);
    Route::resource('/joined-groups', JoinedGroupsController::class)->only(['index']);
    Route::resource('/account', AccountController::class)->only(['index']);

    // NOTE: ADMIN
    Route::resource('/manage-groups', ManageGroupsController::class);
    Route::resource('/manage-users', ManageUsersController::class);
    Route::resource('/manage-roles-permissions', ManageRolesPermissionsController::class)->only(['index', 'create']);
    Route::resource('/system-settings', SystemSettingsController::class)->only(['index', 'update']);
  });
});

