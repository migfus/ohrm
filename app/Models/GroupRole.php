<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    use HasFactory, HasUuids;

  protected $fillable  = ['name', 'display_name', 'description', 'icon_name'];

  public function group_permission_role() {
    return $this->belongsToMany(GroupPermission::class)->withTimestamps();
  }

  public function group_members() {
    return $this->hasMany(GroupMember::class);
  }

  public function hero_icon() {
    return $this->belongsTo(HeroIcon::class, 'icon_name', 'name');
  }
}
