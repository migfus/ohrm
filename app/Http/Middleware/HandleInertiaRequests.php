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
          // Auth::attempt(['email' => 'admin@gmail.com', 'password' => '#Admin.123']);
          // dd($request->user()->id);
          return $request->user() ? $request->user()->only('id', 'name', 'email', 'avatar') : null;
        },
        'flash' => [
          'message' => fn() => $request->session()->get('message')
        ],
      ]);
    }
}
