<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('reaction_users', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->unsignedBigInteger('reaction_id');
      $table->foreign('reaction_id')->references('id')->on('reactions')->onDelete('cascade');
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('reactable_id');
      $table->string('reactable_type');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('reaction_users');
  }
};
