<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class MeterLog extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'old_meter_id', 'new_meter_id', 'changed_at'];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function oldMeter()
    {
        return $this->belongsTo(Meter::class, 'old_meter_id');
    }

    public function newMeter()
    {
        return $this->belongsTo(Meter::class, 'new_meter_id');
    }

}
