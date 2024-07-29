<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyGroupsController extends Controller
{
  public function index(Request $req) : Response {
    $auth_id = auth()->user()->id;

    return Inertia::render('dashboard/my-groups/(Index)' ,
      [
        'page_title' => 'My Groups',
        'groups' => $this->getGroups($req, $auth_id),
        'posts'  => $this->getPosts($req, $auth_id),
      ]
    );
  }

    private function getPosts(Request $req, $auth_id) {
      $group_ids = Group::query()
        ->whereHas('group_members', function($q) use($auth_id) {
          $q->where('user_id', $auth_id)->with('role');
        })
        ->get()
        ->map(fn($row) => [$row->id])
        ->toArray();

      return Post::query()
        ->whereIn('group_id', $group_ids)
        ->with(['user'])
        ->orderBy('created_at', 'desc')
        ->get();
    }
    private function getGroups(Request $req) {
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
