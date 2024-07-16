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
        'name' => 'Instagram Post Ideas'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://images.unsplash.com/photo-1619983081563-430f63602796?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'thumbnail_url' => 'https://images.unsplash.com/photo-1619983081563-430f63602796?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'name' => 'Instagram Post Ideas'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://plus.unsplash.com/premium_photo-1680297665011-597de783fb92?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cmVjb3Jkc3xlbnwwfHwwfHx8MA%3D%3D',
        'thumbnail_url' => 'https://plus.unsplash.com/premium_photo-1680297665011-597de783fb92?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cmVjb3Jkc3xlbnwwfHwwfHx8MA%3D%3D',
        'name' => 'Instagram Post Ideas'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://images.unsplash.com/photo-1580656449278-e8381933522c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fHJlY29yZHN8ZW58MHx8MHx8fDA%3D',
        'thumbnail_url' => 'https://images.unsplash.com/photo-1580656449278-e8381933522c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fHJlY29yZHN8ZW58MHx8MHx8fDA%3D',
        'name' => 'Instagram Post Ideas'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Multimedia Post')->first()->id,
        'data_type' => 'jpg',
        'file_url' => 'https://images.unsplash.com/photo-1602848597941-0d3d3a2c1241?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fHJlY29yZHN8ZW58MHx8MHx8fDA%3D',
        'thumbnail_url' => 'https://images.unsplash.com/photo-1602848597941-0d3d3a2c1241?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fHJlY29yZHN8ZW58MHx8MHx8fDA%3D',
        'name' => 'Instagram Post Ideas'
      ]);






      PostContent::create([
        'post_id' => Post::where('title', 'Documents Post')->first()->id,
        'data_type' => 'docx',
        'file_url' => 'https://media.sproutsocial.com/uploads/2017/01/Instagram-Post-Ideas.png',
        'thumbnail_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbYQcLfUfqY6nAiwop5kkdkSvuKg0qzIc2TA&s',
        'name' => 'PDS Document 2024'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Documents Post')->first()->id,
        'data_type' => 'xlsx',
        'file_url' => 'https://images.unsplash.com/photo-1619983081563-430f63602796?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'thumbnail_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTroU91FLk1e5CTmveZCstER9A-qLpJGNtZvA&s',
        'name' => 'Files for JO'
      ]);

      PostContent::create([
        'post_id' => Post::where('title', 'Documents Post')->first()->id,
        'data_type' => 'pdf',
        'file_url' => 'https://plus.unsplash.com/premium_photo-1680297665011-597de783fb92?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cmVjb3Jkc3xlbnwwfHwwfHx8MA%3D%3D',
        'thumbnail_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1667px-PDF_file_icon.svg.png',
        'name' => 'Files for JO'
      ]);
    }
}
