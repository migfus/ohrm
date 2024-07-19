<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('reactions', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('content');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('reactions');
  }
};
