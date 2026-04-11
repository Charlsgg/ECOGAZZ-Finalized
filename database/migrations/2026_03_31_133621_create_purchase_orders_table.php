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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            
            // Who are you buying from? (e.g., Petron, Shell, Local Oil Distributor)
            $table->string('supplier_name');
            
            // The physical receipt or invoice number for your records
            $table->string('reference_number')->nullable(); 
            
            // How much the entire delivery cost
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', ['Pending', 'Received', 'Cancelled'])->default('Pending');
            $table->date('delivery_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
