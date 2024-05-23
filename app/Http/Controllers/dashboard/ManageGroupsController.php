<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Team;
use App\Models\User;

class ManageGroupsController extends Controller
{
  public function index(Request $req): Response {
    $groups = Team::query()
      ->select('display_name', 'name', 'id', 'avatar')
      ->whereNot('name', 'system')
      ->when($req->search != '', function ($q) use($req) {
        $q->where(`display_name`, `LIKE`, `%`.$req->search.`%`);
      })
      ->with(['users' => function($q) {
      }])
      ->paginate(10);

    return Inertia::render(
      'dashboard/manage-groups/(Index)',
      [
        'pageTitle' => 'Manage Groups',
        'data' => $groups,
        'tabs' => [
          ['name' => 'All'],
        ],
        'filters' => [
          'search' => $req->search
        ],
      ]
    );
  }

  public function create(Request $req): Response  {
    $users = User::query()
      ->whereNot('id', $req->user()->id)
      ->select('name', 'id', 'avatar')
      ->get();

    return Inertia::render(
      'dashboard/manage-groups/(Create)',
      [
        'pageTitle' => 'Create Group',
        'users' => $users
      ]
    );
  }
  public function store(Request $req): RedirectResponse {
    $val = $req->validate([
      'name' => ['required', 'unique:teams,name'],
      'description' => ['required'],
      'avatar' => ['required'],
      'cover' => ['required'],
      'invitedUsers.*' => ['required', 'uuid'],
    ]);

    $team = Team::create([
      'name' => $req->name,
      'display_name' => $req->name,
      'description' => $req->description,
      'avatar' => $req->avatar,
      'cover' => $req->cover,
    ]);
    // NOTE: ADD ROLE to auth->user as Head
    $req->user()->addRole('head', $team->name);

    // NOTE: Invited User as Staff in group;
    foreach($req->invitedUsers as $userId) {
      User::where('id', $userId)->first()->addRole('staff', $team->name);
    }

    return to_route('dashboard.manage-groups.index')->with('flash', ['success' => 'Successfuly Added']);
  }

  public function edit(Request $req, $id): Response {
    $data = Team::query()
      ->select('id', 'name', 'display_name', 'avatar', 'cover')
      ->where('id', $id)
      ->whereNot('name', 'system')
      ->with(['head'])
      ->first();

    return Inertia::render('dashboard/manage-groups/(Edit)', [
      'pageTitle' => $data->display_name,
      'data' => $data,
    ]);
  }

  // NOTE: Remove
  public function destroy($id) : RedirectResponse {
    return to_route('dashboard.manage-groups.index')->with('flash', ['success' => 'Successfuly Removed']);
  }
}
