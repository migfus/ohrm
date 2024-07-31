<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
  use HasFactory, Notifiable, HasRolesAndPermissions, HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'name',
    'email',
    'avatar',
    'cover',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected function casts(): array {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function group_members() : HasMany {
    return $this->hasMany(GroupMember::class);
  }

  public function task_activity() : HasMany {
    return $this->hasMany(UserTaskActivity::class);
  }
}
