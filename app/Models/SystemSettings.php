<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemSettings extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'description', 'value', 'sort_id', 'system_setting_type_id'];

  public function system_setting_type() : BelongsTo {
    return $this->belongsTo(SystemSettingType::class);
  }
}
