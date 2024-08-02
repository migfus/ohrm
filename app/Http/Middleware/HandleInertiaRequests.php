<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSettings;
use App\Models\Task;

class HandleInertiaRequests extends Middleware
{
  protected $rootView = 'app';

  public function version(Request $req): ?string {
    return parent::version($req);
  }

  public function share(Request $req): array {
    return array_merge(parent::share($req), [
      // NOTE: SYSTEM
      'title' => SystemSettings::where('name', 'System Name (Title)')->first()->value,
      'sidebar' => false, // Enable Sidebar Layout [default = false]
      'logo' => [
        'lg' => SystemSettings::where('name', 'System Logo')->first()->value,
        'sm' => SystemSettings::where('name', 'System Small Logo (for page title)')->first()->value,
      ],
      'flash' => [
        'error' => fn () => $req->session()->get('error'),
        'success' => fn () => $req->session()->get('success'),
      ],
      // NOTE: AUTH
      'auth' => function() use($req) {
        return Auth::check() ? $req->user()->only('id', 'name', 'email', 'avatar') : null;
      },

      'pendind_task_count' => 0
    ]);
  }
}
