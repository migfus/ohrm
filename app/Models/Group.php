<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Group extends Model
{
    use HasFactory, HasUuids;

  protected $fillable = ['name', 'description', 'cover', 'avatar'];

  public function group_members() {
    return $this->hasMany(GroupMember::class);
  }

  public function group_members_admin_only() {
    return $this->hasMany(GroupMember::class)->whereHas('role', function($q) {
      $q->where('name', 'admin');
    });
  }

  public function group_members_member_only() {
    return $this->hasMany(GroupMember::class)->whereHas('role', function($q) {
      $q->whereNot('name', 'admin');
    });
  }
}
