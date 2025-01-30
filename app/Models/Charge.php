<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'date',
        'payment_id',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
