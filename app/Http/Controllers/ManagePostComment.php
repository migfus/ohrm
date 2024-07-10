<?php

namespace App\Http\Controllers;

use App\Events\PostEvent;
use Illuminate\Http\Request;

use App\Models\PostComment;
use App\Events\UpdateGroupPostsEvent;

class ManagePostComment extends Controller
{
  public function store(Request $req) {
    $req->validate([
      'postId' => ['required', 'uuid'],
      'content' => ['required'],
    ]);

    PostComment::create([
      'user_id' => $req->user()->id,
      'post_id' => $req->postId,
      'content' => $req->content,
    ]);

    PostEvent::dispatch(
      $req->postId,
      'comment',
      PostComment::where('post_id', $req->postId)->with('user')->get()->toArray()
    );

    return response()->json(['success' => true]);
  }

  public function destroy(Request $req, $id) {
    $req->validate([
      'postId' => ['required', 'uuid'],
    ]);

    PostComment::find($id)->delete();

    PostEvent::dispatch(
      $req->postId,
      'comment',
      PostComment::where('post_id', $req->postId)->with('user')->get()->toArray()
    );

    return response()->json(['success' => true]);
  }
}
