<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser  extends Model
{
  public $guarded = [];
  protected $table = 'role_user';

  public function team() {
    return $this->belongsTo(Team::class);
  }
}
