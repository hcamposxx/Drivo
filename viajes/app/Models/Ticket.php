<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'image',
        'priority',
        'status',
        'admin_response',
        'admin_id',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    //Funciones del ticket

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

//funcion para el admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

//color segun el estado del ticket
public function getStatusBadgeAttribute()
    {
        $badges = [
            'abierto' => 'is-danger',
            'en_proceso' => 'is-warning',
            'resuelto' => 'is-success',
            'cerrado' => 'is-light'
        ];

        return $badges[$this->status] ?? 'is-light';
    }

//prioridad de los tickets
    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'baja' => 'is-info',
            'media' => 'is-warning',
            'alta' => 'is-danger'
        ];

        return $badges[$this->priority] ?? 'is-light';
    }

}
