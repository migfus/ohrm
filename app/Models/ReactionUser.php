<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionUser extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['reaction_id', 'user_id', 'reactable_type', 'reactable_id'];

  public function reaction() {
    return $this->belongsTo(Reaction::class);
  }
}
