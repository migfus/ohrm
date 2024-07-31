<?php
namespace Database\Seeders;

use App\Models\Post;
use App\Models\Reaction;
use App\Models\ReactionUser;
use App\Models\User;

use Illuminate\Database\Seeder;

class ReactionUserSeeder extends Seeder
{
  public function run(): void {
    $data = [
      [
        'reaction_id' => Reaction::where('name', 'Like')->first()->id,
        'user_id' => User::where('name', '[Admin User]')->first()->id,
        'reactable_id' => Post::where('title', 'Basic Post')->first()->id,
        'reactable_type' => 'App\Models\Post',
      ]
    ];

    foreach($data as $item) {
      ReactionUser::create($item);
    }
  }
}
