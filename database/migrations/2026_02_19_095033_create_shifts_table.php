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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            
            // The pump attendant assigned to this shift
            $table->foreignId('user_id')->constrained('users');
            
            // 1. TIME TRACKING & ANTI-CHEAT
            $table->date('shift_date');
            
            // The Target Schedule (When they are SUPPOSED to be there)
            $table->dateTime('scheduled_start'); 
            $table->dateTime('scheduled_end');   
            
            // The Actual Reality (When they ACTUALLY clicked the Start/End buttons)
            $table->timestamp('opened_at')->nullable(); 
            $table->timestamp('closed_at')->nullable();
            
            // Anti-Cheat Locks: If they clock in early/late, requires a manager's PIN
            $table->foreignId('manager_override_id')->nullable()->constrained('users'); 
            $table->string('override_reason')->nullable(); // e.g., "Late due to traffic"

            // 2. THE SYSTEM'S MATH (Calculated from pump readings & item sales)
            $table->decimal('gross_sales', 10, 2)->default(0); // Fuel + Retail Items
            $table->decimal('total_deductions', 10, 2)->default(0); // Expenses, Vales
            $table->decimal('total_charge_slips', 10, 2)->default(0); // Magsaysay P.O.s
            
            // (Gross Sales) - (Deductions) - (Charge Slips) = Expected Cash
            $table->decimal('expected_cash', 10, 2)->default(0); 
            
            // 3. THE MANAGER'S REALITY CHECK
            $table->decimal('actual_cash_remitted', 10, 2)->default(0); // Physical cash counted
            $table->decimal('short_over', 10, 2)->default(0); // Negative = Short, Positive = Over
            
            // Shift lifecycle
            $table->enum('status', ['Open', 'Closed', 'Approved'])->default('Open');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};