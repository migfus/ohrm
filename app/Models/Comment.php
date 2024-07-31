<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['user_id', 'commentable_type', 'commentable_id', 'content'];

  public function user() : BelongsTo {
    return $this->belongsTo(User::class);
  }
}
