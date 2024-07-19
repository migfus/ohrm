<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Reaction;

class ReactionSeeder extends Seeder
{
    public function run(): void {
      $data = [
        ['name' => 'Like', 'content' => '👍'],
        ['name' => 'Heart', 'content' => '😍'],
        ['name' => 'Laugh', 'content' => '🤣'],
        ['name' => 'Shock', 'content' => '😲'],
        ['name' => 'Sad', 'content' => '😭'],
        ['name' => 'Angry', 'content' => '🤬'],
      ];

      foreach($data as $row) {
        Reaction::create($row);
      }
    }
}
