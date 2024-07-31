<?php
namespace App\Http\Controllers\dashboard;

use Inertia\Response;
use Inertia\Inertia;

class AccountController extends Controller
{
  public function index() : Response {
    return Inertia::render('dashboard/account/(Index)', [
      'page_title' => 'Account'
    ]);
  }
}
