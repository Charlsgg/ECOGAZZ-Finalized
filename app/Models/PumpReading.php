<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PumpReading extends Model
{
    protected $fillable = [
        'shift_id', 'fuel_config_id', 'start_meter', 'close_meter', 
        'liters_sold', 'price_per_liter', 'total_amount', 'calibration'
    ];

    public function shift() { return $this->belongsTo(Shift::class); }
    public function nozzle() { return $this->belongsTo(FuelConfig::class, 'fuel_config_id'); }
}