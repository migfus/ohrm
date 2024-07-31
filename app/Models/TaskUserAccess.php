<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TaskUserAccess extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['user_id', 'task_template_id'];

  public function user() : BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function task_template() : BelongsTo {
    return $this->belongsTo(TaskTemplate::class);
  }
}
