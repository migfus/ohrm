<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPriority extends Model
{
    use HasFactory, HasUuids;

  public function hero_icon() {
    return $this->belongsTo(HeroIcon::class, 'hero_icon', 'name');
  }
}
