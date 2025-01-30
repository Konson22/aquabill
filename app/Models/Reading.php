<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'previous',
        'meter_id',
        'source',
        'date',
    ];

    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class);
    }
}
