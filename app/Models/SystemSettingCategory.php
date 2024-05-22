<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SystemSettingCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'sort_id', 'description', 'href'];

    public function system_settings() {
      return $this->hasMany(SystemSettings::class);
    }
}
