<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyReportsController extends Controller
{
  public function index() : Response {
    return Inertia::render('home/(Index)' , [
      'page_title'      => 'My Report',
      'data' => 'test'
    ]);
  }
}
