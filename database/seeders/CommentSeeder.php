<?php
namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

use App\MOdels\User;

class CommentSeeder extends Seeder
{
    public function run(): void {
      $data = [
        [
          'user_id' => User::where('name', '[Admin User]')->first()->id,
          'commentable_id' => Post::where('title', 'Basic Post')->first()->id,
          'commentable_type' => 'App\Models\Post',
          'content' => 'This is a 1st test comment.'
        ],
        [
          'user_id' => User::where('name', '[Admin User]')->first()->id,
          'commentable_id' => Post::where('title', 'Basic Post')->first()->id,
          'commentable_type' => 'App\Models\Post',
          'content' => 'This is a 2nd test comment.'
        ],
      ];

      foreach($data as $item) {
        Comment::create($item);
      }
    }
}
