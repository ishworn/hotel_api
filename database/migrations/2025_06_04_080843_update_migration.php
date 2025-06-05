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
        Schema::create('positions', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // e.g., "Housekeeping Supervisor"
    $table->unsignedBigInteger('department_id'); // 👈 FK column
    $table->string('role'); // e.g., "supervisor", "staff", "manager"
    $table->json('access_sections')->nullable(); // ["rooms", "cleaning_logs"]
    $table->timestamps();
    $table->foreign('department_id')
          ->references('id')
          ->on('departments')
          ->onDelete('cascade');

  
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
