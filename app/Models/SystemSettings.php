<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'description', 'value', 'sort_id', 'system_setting_type_id'];

  public function system_setting_type () {
    return $this->belongsTo(SystemSettingType::class);
  }
}
