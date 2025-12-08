<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',
        'message',
        'is_read',
        'response',
        'response_date',
        'response_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'response_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'response_date' => 'datetime'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForTrip($query, $tripId)
    {
        return $query->where('trip_id', $tripId);
    }

    /**
 * Marcar respuesta como leída
 */
public function markResponseAsRead()
{
    $this->update(['response_read' => true]);
}

/**
 * Scope para respuestas no leídas
 */
public function scopeUnreadResponses($query)
{
    return $query->whereNotNull('response')->where('response_read', false);
}

/**
 * Verificar si tiene respuesta
 */
public function hasResponse()
{
    return !is_null($this->response);
}

}