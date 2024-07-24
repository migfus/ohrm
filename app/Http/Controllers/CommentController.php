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

    $comment_id = Comment::create([
      'user_id' => $req->user()->id,
      'commentable_type' => 'App\Models\Post',
      'commentable_id' => $req->post_id,
      'content' => $req->content,
    ])->id;

    return response()->json(
      Comment::where('id', $comment_id)->with('user')->first()
    );
  }

  public function destroy($id) {
    Comment::find($id)->delete();

    return response()->json(['success' => true]);
  }
}
