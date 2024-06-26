<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = [];

  // NOTE: GET TASK PRIORITY
  public function task_priority() {
    return $this->belongsTo(TaskPriority::class, 'default_task_priority_id', 'id');
  }

  public function task_user_assigns() {
    return $this->hasMany(TaskUserAssign::class);
  }


}
