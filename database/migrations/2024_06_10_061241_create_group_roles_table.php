<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
      Schema::create('group_roles', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name');
        $table->string('display_name');
        $table->text('description')->nullable();
        $table->string('icon_name');
        $table->timestamps();
      });
    }

    public function down(): void {
      Schema::dropIfExists('group_roles');
    }
};
