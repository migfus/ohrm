<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinnedPostController extends Controller
{
  public function index(Request $req) {
    $req->validate([
      'group_id' => ['required', 'uuid'],
    ]);

    return response()->json(
      Post::query()
        ->where('group_id', $req->group_id)
        ->where('is_pinned', 1)
        ->with([
          'user',
          'reaction_users' => function($q) {
            $q->select('reaction_id', DB::raw('count(*) as total'), 'reactable_type', 'reactable_id')
              ->groupBy(['reaction_id', 'reactable_type', 'reactable_id'])
              ->with('reaction');
          },
        ])
        ->withCount(['comments'])
        ->orderBy('created_at', 'desc')
        ->get()
    );
  }
}
