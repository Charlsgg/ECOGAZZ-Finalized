<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_id',
        'supplier_name',
        'reference_number',
        'quantity_added',
        'cost_per_liter',
        'total_amount',
        'delivery_date'
    ];

    /**
     * RELATIONSHIP: This delivery was pumped into a specific tank.
     */
    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}