<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phoneno', 'dob', 'gender', 'licence_no', 'token'
    ];
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
