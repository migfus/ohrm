<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('group_task_activities', function (Blueprint $table) {
      $table->id();
      $table->uuid('group_id');
      $table->date('log_at');
      $table->integer('count');
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('group_task_activities');
  }
};
