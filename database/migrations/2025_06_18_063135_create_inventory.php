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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_code')->unique(); // Corresponds to 'id' => "INV001"
            $table->string('name');                     // Product name
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // FK to categories
            $table->integer('quantity');                // Quantity of items
            $table->string('unit');                     // Unit type (e.g., Piece)
            $table->integer('min_stock');               // Minimum stock threshold
            $table->string('supplier');                 // Supplier name
            $table->string('location');                 // Storage location
            $table->date('last_updated');               // Last updated date
            $table->timestamps();                       // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
