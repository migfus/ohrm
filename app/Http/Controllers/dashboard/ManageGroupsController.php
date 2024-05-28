<?php
namespace App\Http\Controllers\dashboard;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManageGroupsController extends Controller
{
  public function index(Request $req): Response {
    $val = $req->validate([
      'search' => [],
    ]);

    $groups = Team::query()
      ->select('display_name', 'name', 'id', 'avatar')
      ->whereNot('name', 'system')
      ->when($req->search != '', function ($q) use($req) {
        $q->where("display_name", 'LIKE', "%$req->search%");
      })
      ->with(['heads', 'members'])
      ->paginate(10);

    return Inertia::render(
      'dashboard/manage-groups/index/(Index)',
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

  // NOTE: STORE
  public function create(Request $req): Response  {
    $users = User::query()
      ->whereNot('id', $req->user()->id)
      ->select('name', 'id', 'avatar')
      ->get();

    return Inertia::render(
      'dashboard/manage-groups/create/(Create)',
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
      'invitedUsers.*' => ['required'],
      'tasks.*' => ['required'],
    ]);

    $heads = array_filter($req->invitedUsers, function($row) {
      if(isset($row['type'])) {
        if($row['type'] == 'head')
          return true;
      }
      return false;
    });
    $staffs = array_filter($req->invitedUsers, function($row) {
      if(isset($row['type'])) {
        if($row['type'] =='member')
          return true;
      }
      return false;
    });


    // DB::beginTransaction();

    // try {
      $team = Team::create([
        'name' => $req->name,
        'display_name' => $req->name,
        'description' => $req->description,
      ]);
      Team::query()
        ->where('id', $team->id)
        ->update([
          'avatar' => $this->GUploadAvatar($req->avatar, "groups/$team->id/avatar/"),
          'cover' => $this->GUploadAvatar($req->cover, "groups/$team->id/cover/")
        ]);

      // NOTE: ADD ROLE to head
      foreach($heads as $head) {
        User::find($head['id'])->addRole('head', $team->name);
      }
      // NOTE: Invited User as Staff in group;
      foreach($staffs as $staff) {
        User::find($staff['id'])->addRole('staff', $team->name);
      }

      foreach($req->tasks as $task) {
        Task::create([
          'team_id' => $team->id,
          'name' => $task['name'],
        ]);
      }

      return to_route('dashboard.manage-groups.edit', ['manage_group' => $team->id])->with('flash', ['success' => 'Successfuly Added']);
    // }
    // catch(\Exception $e) {
      // DB::rollBack();
      // return to_route('dashboard.manage-groups.create')->withErrors(['Unknown' => 'Something went wrong 😅']);
    // }
  }

  // NOTE: UPDATE
  public function edit(Request $req, $id): Response {
    $users = User::query()
      ->whereNot('id', $req->user()->id)
      ->select('name', 'id', 'avatar')
      ->get();

    $data = Team::query()
      ->select('id', 'name', 'display_name', 'avatar', 'cover', 'description')
      ->where('id', $id)
      ->whereNot('name', 'system')
      ->with(['heads', 'members'])
      ->first();

    return Inertia::render('dashboard/manage-groups/edit/(Edit)', [
      'pageTitle' => $data->display_name,
      'data' => $data,
      'users' => $users,
    ]);
  }
  public function update(Request $req, $id): RedirectResponse {
    switch($req->type) {
      case 'basic':
        $this->UpdateBasic($req, $id);
        break;
      case'remove-member':
        $this->RemoveMember($req, $id);
        break;
      default:
        return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->withErrors(['type' => 'Type value is missing']);
    }

    return to_route('dashboard.manage-groups.edit', ['manage_group' => $id])->with('flash', ['success' => 'Successfuly Updated']);
  }
    private function UpdateBasic(Request $req, $id) : void {
      $val = $req->validate([
        'name' => ['required'],
        'description' => ['required'],
      ]);

      Team::where('id', $id)->update([
        'name' => $req->name,
        'display_name' => $req->name,
        'description' => $req->description,
      ]);
    }
    private function RemoveMember(Request $req, $id) : void {
      $val = $req->validate([
        'memberId' => ['required', 'uuid'],
      ]);

      User::find($req->memberId)->removeRole('staff', Team::find($id)->name);
    }

  // NOTE: Remove
  public function destroy($id) : RedirectResponse {
    return to_route('dashboard.manage-groups.index')->with('flash', ['success' => 'Successfuly Removed']);
  }
}
