<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laratrust\Models\Team as LaratrustTeam;

class Team extends LaratrustTeam
{
  use HasUuids;
  public $guarded = [];

  public function roles() : BelongsToMany {
    return $this->belongsToMany(Role::class, 'role_user');
  }

  public function heads() : BelongsToMany {
    return $this->belongsToMany(User::class, 'role_user')->wherePivot('role_id', Role::where('name', 'head')->first()->id);
  }

  public function members() : BelongsToMany {
    return $this->belongsToMany(User::class, 'role_user')->wherePivot('role_id', Role::where('name', 'staff')->first()->id);
  }

  public function tasks() : HasMany {
    return $this->hasMany(Task::class);
  }
}
