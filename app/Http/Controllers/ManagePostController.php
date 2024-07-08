<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Post;
use Illuminate\Support\Facades\URL;
use Inertia\Response;

class ManagePostController extends Controller
{

  public function index(Request $req) {
    if($req->group_id) {
      return response()->json(
        Post::query()
          ->where('group_id', $req->group_id)
          ->with('user')
          ->orderBy('created_at', 'DESC')
          ->paginate(10)
      );
    }
  }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

  public function update(Request $req, string $id) : RedirectResponse {
    $req->validate([
      'type' => ['required', 'string']
    ]);

    switch($req->type) {
      case 'pin':
        $this->pinPost($id);
        break;
    }


    if($req->redirect) {
      return Redirect::to($req->redirect);
    }

    return to_route('dashboard.manage-groups.index')->with('success', 'Post Removed');
  }
    private function pinPost(string $id) : void {
      $pinToggle = Post::where('id', $id)->first()->is_pinned;

      Post::where('id', $id)->update([
        'is_pinned' => !$pinToggle,
      ]);
    }

  public function destroy(Request $req, string $id) : RedirectResponse{
    Post::where('id', $id)->delete();

    if($req->redirect) {
      return Redirect::to($req->redirect);
    }

    return to_route('dashboard.manage-groups.index')->with('success', 'Post Removed');
  }
}
