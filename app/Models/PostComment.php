<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['post_id', 'user_id', 'content', 'group_id', 'is_pinned', 'post_comment_id'];

  public function user() {
    return $this->belongsTo(User::class);
  }
}
