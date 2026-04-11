<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pump_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fuel_config_id')->constrained()->cascadeOnDelete();
            
            $table->decimal('start_meter', 10, 2)->default(0);
            $table->decimal('close_meter', 10, 2)->default(0);
            $table->decimal('calibration', 10, 2)->default(0); // Pump test fuel
            $table->decimal('liters_sold', 10, 2)->default(0);
            
            // --> THE FIX: Freezing the price at the time of the shift <--
            $table->decimal('price_per_liter', 8, 2)->default(0); 
            
            $table->decimal('total_amount', 10, 2)->default(0); // liters_sold * price_per_liter
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pump_readings');
    }
};