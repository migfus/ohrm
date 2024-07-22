<?php
namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\ReactionUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReactionController extends Controller
{

  public function index() {
    return response()->json(Reaction::orderBy('id', 'ASC')->get());
  }

  public function store(Request $req) {
    $req->validate([
      'post_id'  => ['required', 'uuid'],
      'reaction_id' => ['required'],
    ]);

    $reaction_user = ReactionUser::query()
      ->where('user_id', $req->user()->id)
      ->where('reactable_id', $req->post_id)
      ->where('reactable_type', 'App\Models\Post')
      ->first();

    // NOTE: If the user already reacted, delete and change reaction
    if($reaction_user) {
      if($reaction_user->reaction_id != $req->reaction_id) {
        // Add new reaction
        ReactionUser::create([
          'reaction_id' => $req->reaction_id,
          'reactable_type' => 'App\Models\Post',
          'reactable_id' => $req->post_id,
          'user_id' => $req->user()->id,
        ]);
      }
      // Remove Old Reaction
      $reaction_user->delete();
    }
    // NOTE: If the user not reacted, create a new reaction
    else {
      ReactionUser::create([
        'reaction_id' => $req->reaction_id,
        'reactable_type' => 'App\Models\Post',
        'reactable_id' => $req->post_id,
        'user_id' => $req->user()->id,
      ]);
    }


    return response()->json(
      ReactionUser::where('reactable_id', $req->post_id)
        ->select('reaction_id', DB::raw('count(*) as total'), 'reactable_type', 'reactable_id')
        ->groupBy(['reaction_id', 'reactable_type', 'reactable_id'])
        ->with('reaction')
        ->get()
    );
  }

}
