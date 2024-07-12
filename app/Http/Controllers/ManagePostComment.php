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
      'post_id'  => ['required', 'uuid'],
      'content' => ['required'],
    ]);

    PostComment::create([
      'user_id' => $req->user()->id,
      'post_id' => $req->postId,
      'content' => $req->content,
    ]);

    return response()->json(['success' => true]);
  }

  public function destroy(Request $req, $id) {
    $req->validate([
      'post_id' => ['required', 'uuid'],
    ]);

    PostComment::find($id)->delete();

    return response()->json(['success' => true]);
  }
}
