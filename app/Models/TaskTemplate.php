<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['name', 'description', 'group_id', 'default_task_priority_id', 'is_show' ];

  // NOTE: GET TASK PRIORITY
  public function task_priority() {
    return $this->belongsTo(TaskPriority::class, 'default_task_priority_id', 'id');
  }

  public function task_user_access() {
    return $this->hasMany(TaskUserAccess::class);
  }

  public function group() {
    return $this->belongsTo(Group::class);
  }
}
