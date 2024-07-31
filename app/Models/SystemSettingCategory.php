<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemSettingCategory extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'icon', 'sort_id', 'description', 'href'];

  public function system_settings() : HasMany {
    return $this->hasMany(SystemSettings::class);
  }
}
