<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'size','model','manufactory','date'
    ];

    public function meters()
    {
        return $this->hasMany(Meter::class);
    }
}
