<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fuel_type',
        'capacity',
        'current_stock',
        'low_stock_threshold'
    ];

    /**
     * RELATIONSHIP: One tank supplies fuel to many nozzles (FuelConfigs).
     */
    public function nozzles()
    {
        return $this->hasMany(FuelConfig::class);
    }

    /**
     * RELATIONSHIP: A tank gets filled through many Purchase Orders (Deliveries).
     */
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}