<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
  public function __construct() {
    Inertia::share('sidebar', true);
  }
}
