<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudMatricula extends Model
{
    protected $table = 'solicitudes_matricula';

    protected $fillable = [
        'estudiante_id',
        'nombres',
        'apellidos',
        'cedula',
        'email',
        'telefono',
        'institucion_origen',
        'curso_solicitado_id',
        'periodo_academico_id',
        'adjunto_cedula_path',
        'adjunto_certificado_path',
        'estado',
        'observaciones',
        'revisado_por',
        'fecha_revision',
    ];

    protected function casts(): array
    {
        return [
            'fecha_revision' => 'datetime',
        ];
    }

    /**
     * Relación con Estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Relación con Curso Solicitado
     */
    public function cursoSolicitado(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_solicitado_id');
    }

    /**
     * Relación con Período Académico
     */
    public function periodoAcademico(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    /**
     * Relación con Usuario Revisor
     */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Obtener nombre completo del solicitante
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes aprobadas
     */
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }
}
