<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'task_user_access_id',
      'task_priority_id',
      'task_status_id',
      'task_status_at',
      'expired_at',
      'message'
    ];

  public function task_user_access() {
    return $this->belongsTo(TaskUserAccess::class, 'task_user_access_id');
  }

  public function task_priority() {
    return $this->belongsTo(TaskPriority::class);
  }

  public function task_status() {
    return $this->belongsTo(TaskStatus::class);
  }
}
