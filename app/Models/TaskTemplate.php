<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskTemplate extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['name', 'message', 'group_id', 'default_task_priority_id', 'is_show' ];

  // NOTE: GET TASK PRIORITY
  public function task_priority() : BelongsTo {
    return $this->belongsTo(TaskPriority::class, 'default_task_priority_id', 'id');
  }

  public function task_user_access() : HasMany {
    return $this->hasMany(TaskUserAccess::class);
  }

  public function group() : BelongsTo {
    return $this->belongsTo(Group::class);
  }

  public function tasks() : HasMany {
    return $this->hasMany(Task::class, 'task_template_id', 'id');
  }
}
