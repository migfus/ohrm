<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

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
      ]);
    }
}
