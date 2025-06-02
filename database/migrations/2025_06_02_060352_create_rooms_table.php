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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->enum('type', ['Standard', 'Deluxe', 'Suite', 'Presidential', 'Penthouse']);
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available');
            $table->unsignedInteger('floor');
            $table->decimal('price', 10, 2);
            $table->date('last_cleaned')->nullable();
            $table->json('images')->nullable();
            $table->json('features')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('capacity');
            $table->float('area')->nullable();
            $table->string('bed_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
