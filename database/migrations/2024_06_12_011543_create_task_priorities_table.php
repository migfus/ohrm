<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('task_priorities', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('name');
      $table->string('color', 6);
      $table->string('hero_icon');
      $table->foreign('hero_icon')->references('name')->on('hero_icons')->onDelete('cascade');
      $table->timestamps();
    });
  }


  public function down(): void {
    Schema::dropIfExists('task_priorities');
  }
};
