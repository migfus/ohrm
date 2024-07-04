<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('tasks', function (Blueprint $table) {
      $table->unsignedInteger('id')->primary(); // Format(YYMMDDXXXX) X-[0-9]
      $table->uuid('group_id'); // NOTE: it doesn't make any sense, but I need to bypass the task_templates to group. I hope these data will not in vain
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->uuid('task_template_id');
      $table->foreign('task_template_id')->references('id')->on('task_templates')->onDelete('cascade');
      $table->uuid('user_assignor_id')->nullable();
      $table->foreign('user_assignor_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('user_assigned_id')->nullable();
      $table->foreign('user_assigned_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('task_priority_id');
      $table->foreign('task_priority_id')->references('id')->on('task_priorities')->onDelete('cascade');
      $table->uuid('task_status_id');
      $table->foreign('task_status_id')->references('id')->on('task_statuses')->onDelete('cascade');
      $table->dateTimeTz('task_status_at');
      $table->dateTimeTz('expired_at')->nullable();
      $table->text('message')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('tasks');
  }
};
