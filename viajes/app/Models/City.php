<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'short_name'];

  // Rutas donde esta ciudad es el origen
    public function originRoutes()
    {
        return $this->hasMany(CityRoute::class, 'origin_city_id');
    }

    // Rutas donde esta ciudad es el destino
    public function destinationRoutes()
    {
        return $this->hasMany(CityRoute::class, 'destination_city_id');
    }

    // Obtener todas las ciudades destino disponibles desde esta ciudad
    public function availableDestinations()
    {
        return $this->belongsToMany(
            City::class,
            'city_routes',
            'origin_city_id',
            'destination_city_id'
        );
    }

    // Obtener todas las ciudades desde donde se puede venir a esta ciudad
    public function availableOrigins()
    {
        return $this->belongsToMany(
            City::class,
            'city_routes',
            'destination_city_id',
            'origin_city_id'
        );
    }

}
