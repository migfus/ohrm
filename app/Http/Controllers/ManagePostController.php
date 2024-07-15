<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Events\PostsEvent;

class ManagePostController extends Controller
{
  public function index(Request $req) {
    if($req->group_id) {
      return response()->json(
        Post::query()
          ->where('group_id', $req->group_id)
          ->with(['user'])
          ->orderBy('created_at', 'DESC')
          ->paginate(10)
      );
    }
  }

  public function store(Request $req) : JsonResponse {
    $req->validate([
      'content' => ['required'],
      'group_id'=> ['required', 'uuid'],
    ]);

    $post = Post::create([
      'user_id'  => $req->user()->id,
      'content'  => json_encode($req->content),
      'group_id' => $req->group_id,
    ]);

    PostsEvent::dispatch('new-post', $post->toArray());

    return response()->json(
      Post::query()
        ->where('id', $post->id)
        ->with(['user'])
        ->first()
    );
  }

  public function update(Request $req, string $id) : JsonResponse {
    $req->validate([
      'type' => ['required', 'string']
    ]);

    switch($req->type) {
      case 'pin':
        $this->pinPost($id); break;
      case 'update-content':
        $this->updateContent($req, $id); break;
    }

    $updated_post = Post::query()
      ->where('id', $id)
      ->with(['user'])
      ->first();

    return response()->json($updated_post);
  }
    private function pinPost(string $id) : void {
      $pin_toggle = Post::where('id', $id)->first()->is_pinned;

      Post::where('id', $id)->update([
        'is_pinned' => !$pin_toggle,
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


  public function destroy(string $id) : JsonResponse {
    Post::where('id', $id)->delete();

    return response()->json(['success' => true]);
  }
}
