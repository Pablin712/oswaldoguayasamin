<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'url',
        'es_leida',
        'enviar_email',
        'email_enviado',
        'fecha_envio',
    ];

    protected $casts = [
        'es_leida' => 'boolean',
        'enviar_email' => 'boolean',
        'email_enviado' => 'boolean',
        'fecha_envio' => 'datetime',
    ];

    /**
     * Relación con Usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('es_leida', false);
    }

    /**
     * Scope para notificaciones leídas
     */
    public function scopeLeidas($query)
    {
        return $query->where('es_leida', true);
    }

    /**
     * Scope para notificaciones por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para notificaciones de un usuario
     */
    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para notificaciones recientes
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    /**
     * Marcar como leída
     */
    public function marcarComoLeida()
    {
        $this->update(['es_leida' => true]);
    }

    /**
     * Marcar como enviada por email
     */
    public function marcarEmailEnviado()
    {
        $this->update([
            'email_enviado' => true,
            'fecha_envio' => now(),
        ]);
    }
}
