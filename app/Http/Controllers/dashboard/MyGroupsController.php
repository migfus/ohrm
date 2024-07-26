<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyGroupsController extends Controller
{
  public function index() : Response {
    $auth_id = auth()->user()->id;
    $groups = Group::query()
      ->whereHas('group_members', function($q) use($auth_id) {
        $q->where('user_id', $auth_id)->with('role');
      })
      ->with('group_members.role')
      ->get();

    return Inertia::render('dashboard/MyGroups' ,
      ['page_title' => 'My Groups', 'groups' => $groups]
    );
  }
}
