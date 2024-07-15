<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
  public function run(): void {
    $data = [
      ['name' => 'Basic'],
      ['name' => 'Multimedia'], // photos/videos
      ['name' => 'Documents'], // any documents [pdf, docx, excel, pptx, png, jpg, gif]
    ];

    foreach ($data as $item) {
      PostType::create($item);
    }
  }
}
