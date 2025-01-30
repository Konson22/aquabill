<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial',
        'status',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Reading::class);
    }

}
