<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up(): void {
    Schema::create('post_contents', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('post_id');
      $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
      $table->string("data_type");  // pdf, jpg, png, etc.
      $table->text("file_url"); // original file URL
      $table->text("thumbnail_url"); // miniature file URL
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('post_contents');
  }
};
