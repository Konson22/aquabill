<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'date',
        'category_id',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

     public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
