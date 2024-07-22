<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['user_id', 'commentable_type', 'commentable_id', 'content'];

  public function user() {
    return $this->belongsTo(User::class);
  }
}
