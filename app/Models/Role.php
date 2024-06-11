<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
  use HasUuids;
  public $guarded = [];


  public function attachPermission($permissionId)
  {
      return $this->permissions()->attach($permissionId);
  }

  public function detachPermission($permissionId)
  {
      return $this->permissions()->detach($permissionId);
  }

  public function hero_icon() {
    return $this->belongsTo(HeroIcon::class, 'icon_name', 'name');
  }
}
