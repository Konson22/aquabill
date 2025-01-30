<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'location_id',
        'category_id',
        'meter_id',
        'contract',
        'date',
        'credit',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function meter()
    {
        return $this->belongsTo(Meter::class, 'meter_id');
    }
    public function meters()
    {
        return $this->hasMany(Meter::class, 'id', 'id');
    }
    
    public function lastReading(): HasOne
    {
        return $this->hasOne(Reading::class, 'meter_id', 'meter_id')->latest('created_at');
    }
   
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
