<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUuids;
  protected $fillable = ['post_id', 'user_id', 'group_id', 'post_type_id', 'title', 'is_pinned'];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function comments() {

  }
}
