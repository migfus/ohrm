<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PostContent extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['post_id', 'data_type', 'file_url', 'thumbnail_url', 'name'];
}
