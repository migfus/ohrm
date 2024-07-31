<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory, HasUuids;
  protected $fillable = ['post_id', 'user_id', 'group_id', 'post_type_id', 'title', 'is_pinned'];

  public function user() : BelongsTo  {
    return $this->belongsTo(User::class);
  }

  public function post_contents() : HasMany {
    return $this->hasMany(PostContent::class);
  }

  public function post_type() : BelongsTo  {
    return $this->belongsTo(PostType::class);
  }

  public function reaction_users() : MorphMany  {
    return $this->morphMany(ReactionUser::class, 'reactable');
  }

  public function auth_reaction() : MorphOne {
    return $this->morphOne(ReactionUser::class, 'reactable');
  }

  public function comments() : MorphMany {
    return $this->morphMany(Comment::class, 'commentable');
  }

  public function group() : BelongsTo {
    return $this->belongsTo(Group::class);
  }
}
