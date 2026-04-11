<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelConfig extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pump_id',
        'tank_id',
        'fuel_type',
        'cost_price',
        'selling_price',
        'current_meter',
    ];

    /**
     * RELATIONSHIP: The nozzle belongs to a specific physical Pump Island.
     */
    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    /**
     * RELATIONSHIP: The nozzle draws fuel from a specific Underground Tank.
     */
    public function tank()
    {
        return $this->belongsTo(Tank::class); // Note: Ensure you make a Tank model later
    }

    /**
     * RELATIONSHIP: This nozzle has many shift readings over time.
     */
    public function readings()
    {
        return $this->hasMany(PumpReading::class);
    }
}