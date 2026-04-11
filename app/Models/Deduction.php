<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shift_id',
        'category',
        'amount',
    ];

    /**
     * RELATIONSHIP: Every deduction belongs to a specific shift.
     * This allows the system to subtract this amount from the attendant's total cash.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}