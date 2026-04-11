<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'user_id', 'shift_date', 'scheduled_start', 'scheduled_end', 
        'opened_at', 'closed_at', 'gross_sales', 'total_deductions', 
        'total_charge_slips', 'expected_cash', 'actual_cash_remitted', 
        'short_over', 'status'
    ];

    public function attendant() { return $this->belongsTo(User::class, 'user_id'); }
    public function pumpReadings() { return $this->hasMany(PumpReading::class); }
    public function itemSales() { return $this->hasMany(ItemSale::class); }
    public function chargeSlips() { return $this->hasMany(ChargeSlip::class); }
    public function deductions() { return $this->hasMany(Deduction::class); }
}