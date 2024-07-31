<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskTemplate;
use App\Models\TaskUserAccess;
use Mockery\Matcher\Any;

class TestController extends Controller
{
  public function index(Request $req) {
    return $this->testUserWithOwnTask($req);
  }


  private function testUserWithOwnTask(Request $req) {

  }
}
