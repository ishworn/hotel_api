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
      Schema::create('bookings', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('room_id'); // Foreign key to room type
    $table->string('room_type'); // For display purposes
    $table->string('room_number')->nullable(); // Optional room assignment

    $table->string('booking_reference')->unique(); // Unique booking ID

    $table->string('name');
    $table->string('email')->nullable();
    $table->string('phone');
    $table->integer('guests')->default(1);

    $table->date('check_in');
    $table->date('check_out');
    $table->integer('nights');

    $table->decimal('room_rate', 8, 2);
    $table->decimal('total_amount', 10, 2);

    $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
    
    $table->timestamps();

    $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
