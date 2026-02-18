<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Justificacion extends Model
{
    protected $table = 'justificaciones';

    protected $fillable = [
        'asistencia_id',
        'padre_id',
        'motivo',
        'archivo_adjunto',
        'estado',
        'revisado_por',
        'fecha_revision',
        'motivo_rechazo',
    ];

    protected $casts = [
        'fecha_revision' => 'datetime',
    ];

    /**
     * Relación con Asistencia
     */
    public function asistencia(): BelongsTo
    {
        return $this->belongsTo(Asistencia::class);
    }

    /**
     * Relación con Padre que justifica
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Padre::class);
    }

    /**
     * Relación con Usuario que revisa
     */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para justificaciones pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para justificaciones aprobadas
     */
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    /**
     * Scope para justificaciones rechazadas
     */
    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }
}
