<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_no', 'model_no', 'manufacture_year', 'manufacture_company', 'color','image_file'
    ];
    public function manager(){
        return $this->hasMany(Manager::class);
    }
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
