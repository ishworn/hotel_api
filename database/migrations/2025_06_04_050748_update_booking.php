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
        
         Schema::table('bookings', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn(['name', 'email', 'phone']);

            // Add customer_id foreign key (make sure customers table exists)
            $table->unsignedBigInteger('customer_id')->after('id'); // Adjust position if needed
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
           Schema::table('bookings', function (Blueprint $table) {
            // Re-add the old columns
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            // Drop foreign key and column
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
