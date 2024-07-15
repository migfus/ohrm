<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://media.sproutsocial.com/uploads/2017/01/Instagram-Post-Ideas.png',
        'thumbnail_url' => 'https://media.sproutsocial.com/uploads/2017/01/Instagram-Post-Ideas.png',
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://images.unsplash.com/photo-1619983081563-430f63602796?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'thumbnail_url' => 'https://images.unsplash.com/photo-1619983081563-430f63602796?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
      ]);
    }
}
