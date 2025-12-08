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

    /**
 * Relación con los mensajes del viaje
 */
public function messages()
{
    return $this->hasMany(TripMessage::class)->with('user')->orderBy('created_at', 'desc');
}

/**
 * Obtener mensajes no leídos
 */
public function unreadMessages()
{
    return $this->hasMany(TripMessage::class)->where('is_read', false);
}

/**
 * Contar mensajes no leídos
 */
public function unreadMessagesCount()
{
    return $this->unreadMessages()->count();
}

}
