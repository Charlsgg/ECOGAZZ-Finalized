<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpReading extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shift_id',
        'fuel_config_id',
        'start_meter',
        'close_meter',
        'calibration',
        'liters_sold',
        'price_per_liter',
        'total_amount',
    ];

    /**
     * RELATIONSHIP: This reading belongs to a specific employee shift.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * RELATIONSHIP: This reading belongs to a specific nozzle (Fuel Config).
     */
    public function fuelConfig()
    {
        return $this->belongsTo(FuelConfig::class);
    }

    /**
     * LOGIC: Automatically calculate liters sold before saving.
     * (Close Meter - Start Meter - Calibration)
     */
    public function calculateSales()
    {
        $this->liters_sold = $this->close_meter - $this->start_meter - $this->calibration;
        $this->total_amount = $this->liters_sold * $this->price_per_liter;
    }
}