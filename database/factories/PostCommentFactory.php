<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Post;
use App\Models\User;

class PostCommentFactory extends Factory
{
  public function definition(): array
  {
    return [
      'post_id' => Post::where('content', '[{"insert":"Currently TEsting for COmments."}]')->first()->id,
      'user_id' => User::where('name', '[Admin User]')->first()->id,
      'content' =>$this->faker->sentence(45)
    ];
  }
}
