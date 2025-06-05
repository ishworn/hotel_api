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
       Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();

    $table->string('phone');
     $table->unsignedBigInteger('position_id'); // 👈 FK column
    $table->date('hire_date');
    $table->string('schedule');
    $table->string('status')->default('active');
    $table->foreign('position_id')
          ->references('id')
          ->on('positions')
          ->onDelete('cascade');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
