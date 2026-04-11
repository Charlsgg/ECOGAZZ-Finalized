<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Underground Tank 1', 'Diesel Main'
            $table->string('fuel_type'); // e.g., 'Diesel', 'Premium'
            
            // Inventory Tracking
            $table->decimal('capacity', 12, 2); // Max volume (e.g., 20,000 liters)
            $table->decimal('current_stock', 12, 2)->default(0); // Current volume
            
            // Warning levels for the Manager
            $table->decimal('low_stock_threshold', 10, 2)->default(1000); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanks');
    }
};