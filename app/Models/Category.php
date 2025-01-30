<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tariff',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
}
