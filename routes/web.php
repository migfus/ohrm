<?php

use App\Http\Controllers\dashboard\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\JoinedGroupsController;
use App\Http\Controllers\dashboard\ManageGroupsController;
use App\Http\Controllers\dashboard\SystemRolesPermissionsController;
use App\Http\Controllers\dashboard\ManageUsersController;
use App\Http\Controllers\dashboard\MyGroupsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\dashboard\SystemSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\dashboard\ManageTemplateTaskController;
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
    Route::resource('/manage-groups', ManageGroupsController::class)->except(['show', 'create']);
      Route::get('/manage-groups/users-suggestion/{id}', [ManageGroupsController::class, 'UserComboBox'])->name('manage-groups.users-suggestion');
    Route::resource('/manage-users', ManageUsersController::class)->except(['show', 'create']);
    Route::resource('/system-roles-permissions', SystemRolesPermissionsController::class)->only(['index', 'update']);
    Route::resource('/system-settings', SystemSettingsController::class)->only(['index', 'update']);
    Route::resource('/manage-template-tasks', ManageTemplateTaskController::class)->only(['edit', 'update']);
      Route::get('/manage-template-tasks/users-suggestion/{id}', [ManageTemplateTaskController::class, 'UserComboBox'])->name('manage-groups.users-suggestion');
  });
});

