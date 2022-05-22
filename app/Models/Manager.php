<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phoneno', 'dob', 'gender', 'token'
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
    public function cars(){
        return $this->belongsTo(Car::class);
    }
}
