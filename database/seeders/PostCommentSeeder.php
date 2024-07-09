<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PostComment;

class PostCommentSeeder extends Seeder
{
  public function run(): void {
    PostComment::factory()->count(20)->create();
  }
}
