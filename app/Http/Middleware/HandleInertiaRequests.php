<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSettings;
use App\Models\Task;
use App\Models\TaskUserAccess;

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

      'pending_task_count' => $this->getPendingTaskCount()
    ]);
  }

    private function getPendingTaskCount() : int {
      $task_template_ids = TaskUserAccess::query()
        ->where('user_id', auth()->user()->id)
        ->with(['task_template'])
        ->get()
        ->pluck('task_template_id')
        ->toArray();

      return Task::query()
        ->whereNull('user_assigned_id')
        // ->with(['task_template'])
        ->whereHas('task_template', function ($q) use($task_template_ids) {
          $q->whereIn('id', $task_template_ids);
        })
        ->count();
    }
}
