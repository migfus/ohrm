<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReactionUser extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['reaction_id', 'user_id', 'reactable_type', 'reactable_id'];

  public function reaction() : BelongsTo {
    return $this->belongsTo(Reaction::class);
  }
}
