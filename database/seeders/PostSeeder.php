<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\User;
use App\Models\Group;
use App\Models\PostType;

class PostSeeder extends Seeder
{
  public function run(): void {
    // NOTE: Basic test
    Post::create([
      'user_id' => User::where('name', '[Admin User]')->first()->id,
      'group_id' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'post_type_id' => PostType::where('name', 'Basic')->first()->id,
      'title' => 'Basic Post',
      'is_pinned' => false,
    ]);

    Post::create([
      'user_id' => User::where('name', '[Admin User]')->first()->id,
      'group_id' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'post_type_id' => PostType::where('name', 'Multimedia')->first()->id,
      'title' => 'Multimedia Post',
      'is_pinned' => false,
    ]);

    Post::create([
      'user_id' => User::where('name', '[Admin User]')->first()->id,
      'group_id' => Group::where('name', 'Office of Human Resources Management Office (OHRM)')->first()->id,
      'post_type_id' => PostType::where('name', 'Documents')->first()->id,
      'title' => 'Documents Post',
      'is_pinned' => false,
    ]);
  }
}
