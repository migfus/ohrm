<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory, HasUuids;

  protected $fillable = ['user_id', 'group_id', 'group_role_id'];

  public function group() {
    return $this->belongsTo(Group::class);
  }

  public function role() {
    return $this->belongsTo(GroupRole::class, 'group_role_id', 'id');
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}
