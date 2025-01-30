<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'address',
        'customer_id',
        'neighborhood_id',
        'latitude',
        'longitude',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }
}
