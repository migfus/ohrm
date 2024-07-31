<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    use HasFactory, HasUuids;

  protected $fillable = ['user_id', 'group_id', 'group_role_id'];

  public function group() : BelongsTo {
    return $this->belongsTo(Group::class);
  }

  public function role() : BelongsTo{
    return $this->belongsTo(GroupRole::class, 'group_role_id', 'id');
  }

  public function user() : BelongsTo {
    return $this->belongsTo(User::class);
  }
}
