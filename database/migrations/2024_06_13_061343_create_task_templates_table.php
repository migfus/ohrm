<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('task_templates', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('group_id');
      $table->uuid('default_task_priority_id');
      $table->string('name');
      $table->text('description')->nullable();
      $table->boolean('is_show');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('task_templates');
  }
};
