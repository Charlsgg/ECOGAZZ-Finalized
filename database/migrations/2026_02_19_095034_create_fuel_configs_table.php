<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_configs', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('pump_id')->constrained('pumps')->cascadeOnDelete(); 
            $table->foreignId('tank_id')->nullable()->constrained('tanks')->nullOnDelete(); 

            $table->string('fuel_type'); 
            $table->decimal('cost_price', 8, 2);
            $table->decimal('selling_price', 8, 2);
            $table->decimal('current_meter', 12, 2)->default(0); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_configs');
    }
};