<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{
  public function index(Request $req) {
    $req->validate([
      'post_id'  => ['required', 'uuid'],
      'group_id' => ['required', 'uuid'],
    ]);

    $comments = Comment::query()
      ->where('commentable_id', $req->post_id)
      ->where('commentable_type', 'App\Models\Post')
      ->with([
        'user.group_members' => function($q) use($req) {
          $q->where('group_id', $req->group_id)->with('role');
        },
      ])
      ->orderBy('created_at', 'DESC')
      ->paginate(3);

    return response()->json($comments);
  }

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

  public function update(Request $req, $id) {
    $req->validate([
      'content' => ['required']
    ]);

    Comment::find($id)->update([
      'content' => $req->content,
    ]);

    return response()->json(['success' => true]);
  }
}
