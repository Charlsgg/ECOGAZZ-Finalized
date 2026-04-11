<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shift_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_amount',
    ];

    /**
     * RELATIONSHIP: This sale belongs to a specific attendant's shift.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * RELATIONSHIP: This sale identifies which product was sold (e.g., Diesel Engine Oil).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * HELPER: Calculate the total based on quantity and price.
     */
    public function calculateTotal()
    {
        $this->total_amount = $this->quantity * $this->unit_price;
    }
}