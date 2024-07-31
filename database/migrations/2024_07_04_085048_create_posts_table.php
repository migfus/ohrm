<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('posts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('group_id');
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->uuid('post_type_id');
      $table->foreign('post_type_id')->references('id')->on('post_types')->onDelete('cascade');
      $table->longText('title');
      $table->boolean('is_pinned')->default(false);
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('posts');
  }
};
