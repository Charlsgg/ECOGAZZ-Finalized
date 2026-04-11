<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tank_id')->nullable()->constrained('tanks')->nullOnDelete();
            $table->string('supplier_name')->nullable();
            $table->string('reference_number')->nullable(); // DR or Invoice Number
            
            $table->decimal('quantity_added', 12, 2); // Liters delivered
            $table->decimal('cost_per_liter', 8, 2);
            $table->decimal('total_amount', 12, 2);
            
            $table->date('delivery_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};