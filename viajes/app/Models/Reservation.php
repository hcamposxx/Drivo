<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'passenger_id',
        'seats',
        'confirmed',
        'active',
        'phone',
        'comment'
    ];

    public function passenger(){
        return $this->belongsTo(User::class,'passenger_id');
    }
}
