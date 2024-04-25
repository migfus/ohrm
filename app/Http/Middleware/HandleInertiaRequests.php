<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSettings;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string {
      return parent::version($request);
    }

    public function share(Request $request): array {
      return array_merge(parent::share($request), [
        'auth' => function() use($request) {
          return Auth::check() ? $request->user()->only('id', 'name', 'email', 'avatar') : null;
        },
        'flash' => [
          'message' => fn() => $request->session()->get('message')
        ],
        'sidebar' => false, // default
        'system_settings' => SystemSettings::select('name', 'config', 'description')->get()->toArray(),
        'title' => 'Office of Human Resources Management'
      ]);
    }
}
