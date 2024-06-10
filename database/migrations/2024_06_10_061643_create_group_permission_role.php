<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void {
    Schema::create('group_permission_group_role', function (Blueprint $table) {
      $table->uuid('group_permission_id');
      $table->foreign('group_permission_id')->references('id')->on('group_permissions')->onDelete('cascade');


      $table->uuid('group_role_id');
      $table->foreign('group_role_id')->references('id')->on('group_roles')->onDelete('cascade');

      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('group_permission_group_role');
  }
};
