<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use App\Events\PostsEvent;

class ManagePostController extends Controller
{

  public function index(Request $req) {
    if($req->groupId) {
      return response()->json(
        Post::query()
          ->where('group_id', $req->groupId)
          ->with(['user', 'comments.user'])
          ->withCount(['comments'])
          ->orderBy('created_at', 'DESC')
          ->paginate(10)
      );
    }
  }

  public function store(Request $req) : JsonResponse {
    $req->validate([
      'content' => ['required'],
      'groupId' => ['required', 'uuid'],
    ]);

    $post = Post::create([
      'user_id' => $req->user()->id,
      'content' => json_encode($req->content),
      'group_id' => $req->groupId,
    ]);

    PostsEvent::dispatch('new-post', $post->toArray());

    return response()->json(
      Post::query()
        ->where('id', $post->id)
        ->with(['user', 'comments.user'])
        ->withCount(['comments'])
        ->first()
    );
  }

  public function update(Request $req, string $id) : JsonResponse {
    $req->validate([
      'type' => ['required', 'string']
    ]);

    switch($req->type) {
      case 'pin':
        $this->pinPost($id);
        break;
      case 'update-content':
        $this->updateContent($req, $id);
        break;
    }

    $updatedPost = Post::query()
      ->where('id', $id)
      ->with(['user', 'comments.user'])
      ->withCount(['comments'])
      ->first();

    PostsEvent::dispatch(
      'post-update',
      $updatedPost->toArray()
    );

    // return to_route('dashboard.manage-groups.index')->with('success', 'Post Removed');
    return response()->json($updatedPost);
  }
    private function pinPost(string $id) : void {
      $pinToggle = Post::where('id', $id)->first()->is_pinned;

      Post::where('id', $id)->update([
        'is_pinned' => !$pinToggle,
      ]);
    }
    private function updateContent(Request $req, string $id) : void {
      $req->validate([
        'content' => ['required'],
      ]);

      Post::where('id', $id)->update([
        'content' => json_encode($req->content),
      ]);
    }


  public function destroy(Request $req, string $id) : JsonResponse {
    Post::where('id', $id)->delete();

    // PostsEvent::dispatch('post-delete', null);

    return response()->json(['success' => true]);
  }
}
