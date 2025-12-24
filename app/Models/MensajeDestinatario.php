<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeDestinatario extends Model
{
    protected $table = 'mensaje_destinatarios';

    protected $fillable = [
        'mensaje_id',
        'destinatario_id',
        'es_leido',
        'fecha_lectura',
    ];

    protected $casts = [
        'es_leido' => 'boolean',
        'fecha_lectura' => 'datetime',
    ];

    /**
     * Relación con Mensaje
     */
    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(Mensaje::class);
    }

    /**
     * Relación con Destinatario
     */
    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    /**
     * Scope para mensajes no leídos
     */
    public function scopeNoLeidos($query)
    {
        return $query->where('es_leido', false);
    }

    /**
     * Scope para mensajes leídos
     */
    public function scopeLeidos($query)
    {
        return $query->where('es_leido', true);
    }

    /**
     * Marcar como leído
     */
    public function marcarComoLeido()
    {
        $this->update([
            'es_leido' => true,
            'fecha_lectura' => now(),
        ]);
    }
}
