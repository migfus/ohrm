<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;

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
        $q->select('avatar', 'name')->limit(8);
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

  public function create(): Response  {
    return Inertia::render('dashboard/manage-groups/(Create)', ['pageTitle' => 'Create Group']);
  }

  public function edit(Request $req, $id): Response {
    $data = Team::query()
      ->select('id', 'name', 'display_name')
      ->whereNot('name', 'system')
      ->where('id', $id)
      ->with(['users' => function($q) {
        $q->select('avatar', 'name');
      }])
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
