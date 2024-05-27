<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('tasks', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('team_id');
        $table->string('name');
        $table->string('description')->nullable();
        $table->string('active')->default(true);
        $table->string('cover')->nullable();

        $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('tasks');
    }
};