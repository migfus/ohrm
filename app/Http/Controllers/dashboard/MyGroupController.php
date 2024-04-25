<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyGroupController extends Controller
{
  public function index() : Response {
    return Inertia::render('mygroups/(Page)');
  }
}
