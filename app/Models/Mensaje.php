<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mensaje extends Model
{
    protected $table = 'mensajes';

    protected $fillable = [
        'remitente_id',
        'destinatario_id',
        'tipo',
        'asunto',
        'cuerpo',
        'es_leido',
        'fecha_lectura',
        'fecha_envio',
        'programado_para',
    ];

    protected $casts = [
        'es_leido' => 'boolean',
        'fecha_lectura' => 'datetime',
        'fecha_envio' => 'datetime',
        'programado_para' => 'datetime',
    ];

    /**
     * Relación con Remitente
     */
    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    /**
     * Relación con Destinatario (para mensajes individuales)
     */
    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    /**
     * Relación con Adjuntos
     */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(MensajeAdjunto::class);
    }

    /**
     * Relación con Destinatarios (para mensajes masivos)
     */
    public function destinatarios(): HasMany
    {
        return $this->hasMany(MensajeDestinatario::class);
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
     * Scope para mensajes de un usuario
     */
    public function scopeRecibidosPor($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('destinatario_id', $userId)
              ->orWhereHas('destinatarios', function($q2) use ($userId) {
                  $q2->where('destinatario_id', $userId);
              });
        });
    }

    /**
     * Scope para mensajes enviados por un usuario
     */
    public function scopeEnviadosPor($query, $userId)
    {
        return $query->where('remitente_id', $userId);
    }

    /**
     * Scope para mensajes por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para mensajes programados
     */
    public function scopeProgramados($query)
    {
        return $query->whereNotNull('programado_para')
                     ->where('programado_para', '>', now())
                     ->whereNull('fecha_envio');
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
