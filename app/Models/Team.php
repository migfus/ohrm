<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laratrust\Models\Team as LaratrustTeam;

class Team extends LaratrustTeam
{
  use HasUuids;
  public $guarded = [];

  public function roles() {
    return $this->belongsToMany(Role::class, 'role_user');
  }

  public function heads() {
    return $this->belongsToMany(User::class, 'role_user')->wherePivot('role_id', Role::where('name', 'head')->first()->id);
  }

  public function members() {
    return $this->belongsToMany(User::class, 'role_user')->wherePivot('role_id', Role::where('name', 'staff')->first()->id);
  }
}
