<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * RELATIONSHIP: A pump island has many nozzles (fuel configs).
     * This links Pump Island 1 to its individual hoses (Diesel, Premium, etc.)
     */
    public function nozzles()
    {
        return $this->hasMany(FuelConfig::class);
    }
}