<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laratrust\Models\Team as LaratrustTeam;

class Team extends LaratrustTeam
{
  use HasUuids;
  public $guarded = [];
}
