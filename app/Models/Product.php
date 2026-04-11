<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category',
        'brand',
        'name',
        'cost_price',
        'selling_price',
        'stock_quantity',
    ];

    /**
     * RELATIONSHIP: A product has many individual sales records.
     */
    public function sales()
    {
        return $this->hasMany(ItemSale::class);
    }

    /**
     * HELPER: Check if stock is low.
     * You can use this to show a warning in your manager dashboard.
     */
    public function isLowStock($threshold = 5)
    {
        return $this->stock_quantity <= $threshold;
    }
}