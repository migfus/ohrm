<?php
namespace App\Http\Controllers;

use App\Events\PostEvent;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Events\UpdateGroupPostsEvent;

class CommentController extends Controller
{
  public function store(Request $req) {
    $req->validate([
      'post_id'  => ['required', 'uuid'],
      'content' => ['required'],
    ]);

    Comment::create([
      'user_id' => $req->user()->id,
      'commentable_type' => 'App\Models\Post',
      'commentable_id' => $req->post_id,
      'content' => $req->content,
    ]);

    return response()->json(['success' => true]);
  }

  public function destroy(Request $req, $id) {
    $req->validate([
      'post_id' => ['required', 'uuid'],
    ]);

    Comment::find($id)->delete();

    return response()->json(['success' => true]);
  }
}
