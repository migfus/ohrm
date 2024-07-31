<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleUser  extends Model
{
  public $guarded = [];
  protected $table = 'role_user';

  public function team() : BelongsTo {
    return $this->belongsTo(Team::class);
  }
}
