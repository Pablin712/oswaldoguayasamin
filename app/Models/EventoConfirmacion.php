<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoConfirmacion extends Model
{
    use HasFactory;

    protected $table = 'evento_confirmacion';

    protected $fillable = [
        'evento_id',
        'user_id',
        'estudiante_id',
        'confirmado',
        'fecha_confirmacion',
        'observaciones',
    ];

    protected $casts = [
        'confirmado' => 'boolean',
        'fecha_confirmacion' => 'datetime',
    ];

    // Relaciones
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Scopes
    public function scopeConfirmados($query)
    {
        return $query->where('confirmado', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('confirmado', false);
    }

    public function scopeDelEvento($query, $eventoId)
    {
        return $query->where('evento_id', $eventoId);
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos
    public function confirmar($observaciones = null)
    {
        $this->update([
            'confirmado' => true,
            'fecha_confirmacion' => now(),
            'observaciones' => $observaciones,
        ]);
    }
}
