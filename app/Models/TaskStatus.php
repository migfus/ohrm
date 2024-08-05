<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskStatus extends Model
{
    use HasFactory, HasUuids;
  protected $fillable = ['hero_icon', 'present_name', 'past_name', 'text_color', 'bg_color'];

  public function hero_icon() : BelongsTo {
    return $this->belongsTo(HeroIcon::class, 'hero_icon', 'name');
  }
}
