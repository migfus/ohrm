<?php
namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\Inertia;

class PageController extends Controller
{
  public function about() : Response {
    return Inertia::render('about/(Index)' , ['page_title' => 'About Us']);
  }
}
