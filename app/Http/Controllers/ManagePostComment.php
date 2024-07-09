<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PostComment;

class ManagePostComment extends Controller
{
  public function create(Request $req) {
    $req->validate([
      'post_id' => ['required', 'uuid'],
      'content' => ['required'],
    ]);

    PostComment::create([
      'user_id' => $req->user()->id,
      'post_id' => $req->post_id,
      'content' => $req->content,
    ]);

    return response()->json(['success' => true]);
  }
}
