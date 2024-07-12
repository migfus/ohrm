<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class JoinedGroupsController extends Controller
{
  public function index() : Response {
    return Inertia::render('dashboard/JoinedGroups', [
      'page_title' => 'Joined Groups'
    ]);
  }
}
