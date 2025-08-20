<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = array('*');

    public function departureCity(){
        return $this->belongsTo(City::class,'departure_city_id');
    }

    public function arrivalCity(){
        return $this->belongsTo(City::class,'arrival_city_id');
    }

    public function driver(){
        return $this->belongsTo(User::class,'driver_id');
    }
}
