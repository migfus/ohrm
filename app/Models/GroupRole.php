<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupRole extends Model
{
  use HasFactory, HasUuids;

  protected $fillable  = ['name', 'display_name', 'description', 'icon_name'];

  public function group_permission_role() : BelongsToMany {
    return $this->belongsToMany(GroupPermission::class)->withTimestamps();
  }

  public function group_members() : HasMany {
    return $this->hasMany(GroupMember::class);
  }

  public function hero_icon() : BelongsTo {
    return $this->belongsTo(HeroIcon::class, 'icon_name', 'name');
  }
}
