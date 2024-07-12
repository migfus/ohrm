<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
  public function definition(): array {
    static $order = 1;
    return [
      'user_id' => User::where('name', '[Admin User]')->first()->id,
      'group_id' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'content' => '[{"insert":"'.$order++.'"}]',
      'is_pinned' => false,
    ];
  }
}
