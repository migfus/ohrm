<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'task_template_id',
      'user_assignor_id',
      'user_assigned_id',
      'task_priority_id',
      'task_status_id',
      'task_status_at',
      'expired_at',
      'name',
      'message',
      'group_id' // NOTE: to bypass the task_templates 🙏
    ];

  public function user_assigned() : BelongsTo {
    return $this->belongsTo(User::class, 'user_assigned_id');
  }

  public function task_template() : BelongsTo  {
    return $this->belongsTo(TaskTemplate::class, 'task_template_id');
  }

  public function task_priority() : BelongsTo {
    return $this->belongsTo(TaskPriority::class);
  }

  public function task_status() : BelongsTo {
    return $this->belongsTo(TaskStatus::class);
  }
}
