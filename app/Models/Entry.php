<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id', 'driver_id', 'status', 'alert_time'
    ];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}
