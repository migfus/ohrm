<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('comments', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('commentable_id');
      $table->string('commentable_type');
      $table->longText('content');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('comments');
  }
};
