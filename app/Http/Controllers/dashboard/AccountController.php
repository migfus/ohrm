<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AccountController extends Controller
{

  public function index() : Response {
    return Inertia::render('account/(Page)');
  }
}
