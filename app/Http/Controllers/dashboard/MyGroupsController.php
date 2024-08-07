<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

use App\Models\Group;
use App\Models\Post;
use App\Models\Task;
use App\Models\TaskStatus;

class MyGroupsController extends Controller
{
  public function index(Request $req) : Response {
    $auth_id = auth()->user()->id;

    return Inertia::render('dashboard/my-groups/(Index)' ,
      [
        'page_title' => 'My Groups',
        'groups' => $this->getGroups($req),
        'posts'  => $this->getPosts($req, $auth_id),
      ]
    );
  }
    private function getPosts($auth_id) : Collection {
      $group_ids = Group::query()
        ->whereHas('group_members', function($q) use($auth_id) {
          $q->where('user_id', $auth_id)->with('role');
        })
        ->get()
        ->map(fn($row) => [$row->id])
        ->toArray();

      return Post::query()
        ->whereIn('group_id', $group_ids)
        ->with(['user', 'group'])
        ->orderBy('created_at', 'desc')
        ->get();
    }
    private function getGroups(Request $req) : Collection {
      $req->validate([
        'search' => []
      ]);

      return Group::query()
        ->when($req->search, function($q) use($req) {
          $q->where(function($q_) use($req) {
            $q_->where('name', 'like', '%'. $req->search. '%')
              ->orWhere('description', 'like', '%'. $req->search. '%');
          });
        })
        ->whereHas('group_members', function($q) {
          $q->where('user_id', auth()->user()->id)->with('role');
        })
        ->with(['group_members' => function($q) {
          $q->where('user_id', auth()->user()->id)
            ->with('role');
        }])
        ->get();
    }
}
