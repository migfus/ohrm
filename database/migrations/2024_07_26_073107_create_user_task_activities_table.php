<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('user_task_activities', function (Blueprint $table) {
      $table->id();
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('count');
      $table->date('log_at');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('user_task_activities');
  }
};
