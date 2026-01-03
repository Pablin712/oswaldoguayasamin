<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matricula extends Model
{
    protected $fillable = [
        'estudiante_id',
        'paralelo_id',
        'periodo_academico_id',
        'numero_matricula',
        'fecha_matricula',
        'tipo_matricula',
        'orden_pago_id',
        'solicitud_matricula_id',
        'estado',
        'fecha_aprobacion',
        'aprobado_por',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_matricula' => 'date',
            'fecha_aprobacion' => 'datetime',
        ];
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function periodoAcademico(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }

    /**
     * Relación con Orden de Pago
     */
    public function ordenPago(): BelongsTo
    {
        return $this->belongsTo(OrdenPago::class);
    }

    /**
     * Relación con Solicitud de Matrícula
     */
    public function solicitudMatricula(): BelongsTo
    {
        return $this->belongsTo(SolicitudMatricula::class);
    }

    /**
     * Relación con Usuario que Aprobó
     */
    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    /**
     * Scope para matrículas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para matrículas aprobadas
     */
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    /**
     * Verificar si es primera matrícula
     */
    public function isPrimeraMatricula(): bool
    {
        return $this->tipo_matricula === 'primera';
    }

    /**
     * Verificar si es segunda matrícula
     */
    public function isSegundaMatricula(): bool
    {
        return $this->tipo_matricula === 'segunda';
    }
}
