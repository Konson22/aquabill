<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'reading_id',
        'tariff',
        'amount',
        'charges',
        'previous_balance',
        'Previouse_bill_no',
        'method',
        'paid',
        'date',
        'status',
        'remaining',
        'description',
    ];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reading()
    {
        return $this->belongsTo(Reading::class);
    }

    public function meter()
    {
        return $this->hasOneThrough(Meter::class, Reading::class, 'id', 'id', 'reading_id', 'meter_id');
    }
}
