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
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// NOTE: PAGES
Route::resource('/', HomeController::class)->only(['index']);
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
    Route::resource('/manage-groups', ManageGroupsController::class)->except('show');
      Route::get('/manage-users/all', [ManageUsersController::class, 'all'])->name('manage-users.all'); // NOTE: manage-groups search all possible users
    Route::resource('/manage-users', ManageUsersController::class)->except('show');
    Route::resource('/manage-roles-permissions', ManageRolesPermissionsController::class)->only(['index', 'create']);
    Route::resource('/system-settings', SystemSettingsController::class)->only(['index', 'update']);
  });
});

