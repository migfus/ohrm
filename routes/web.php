<?php

use App\Http\Controllers\dashboard\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\JoinedGroupsController;
use App\Http\Controllers\dashboard\ManageGroupsController;
use App\Http\Controllers\dashboard\ManageRolesPermissionsController;
use App\Http\Controllers\dashboard\ManageUsersController;
use App\Http\Controllers\dashboard\MyGroupController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\dashboard\SystemSettingsController;
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

  Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {

    // MARK: Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/my-groups', [MyGroupController::class, 'index'])->name('my-groups');
    Route::get('/joined-groups', [JoinedGroupsController::class, 'index'])->name('joined-groups');
    Route::get('/account', [AccountController::class, 'index'])->name('account');

    // MARK: ADMIN
    Route::get('/manage-groups', [ManageGroupsController::class, 'index'])->name('manage-groups');
    Route::get('/manage-users', [ManageUsersController::class, 'index'])->name('manage-users');
    Route::get('/manage-roles-permissions', [ManageRolesPermissionsController::class, 'index'])->name('manage-roles-permissions');
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings');
  });
});

