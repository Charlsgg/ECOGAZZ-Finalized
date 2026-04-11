<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeSlip extends Model
{
    protected $fillable = [
        'shift_id', 'customer_id', 'po_number', 'plate_number', 
        'driver_name', 'item_description', 'amount', 'status', 'transaction_date'
    ];

    public function shift() { return $this->belongsTo(Shift::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
}