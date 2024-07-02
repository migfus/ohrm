<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('tasks', function (Blueprint $table) {
      $table->integer('id')->primary();
      $table->uuid('task_user_assigns_id');
      $table->foreign('task_user_assigns_id')->references('id')->on('task_user_assigns')->onDelete('cascade');
      $table->uuid('task_priority_id');
      $table->foreign('task_priority_id')->references('id')->on('task_priorities')->onDelete('cascade');
      $table->uuid('task_status_id');
      $table->foreign('task_status_id')->references('id')->on('task_statuses')->onDelete('cascade');
      $table->dateTimeTz('task_status_at')->nullable();
      $table->dateTimeTz('expired_at')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('tasks');
  }
};
