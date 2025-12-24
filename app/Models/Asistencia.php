<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asistencia extends Model
{
    protected $fillable = [
        'estudiante_id',
        'paralelo_id',
        'materia_id',
        'docente_id',
        'fecha',
        'hora',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
    ];

    /**
     * Relación con Estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Relación con Paralelo
     */
    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class);
    }

    /**
     * Relación con Materia (opcional)
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Relación con Docente que registra
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación con Justificaciones
     */
    public function justificaciones(): HasMany
    {
        return $this->hasMany(Justificacion::class);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para filtrar asistencias de un estudiante
     */
    public function scopeDeEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Scope para filtrar asistencias de un paralelo
     */
    public function scopeDeParalelo($query, $paraleloId)
    {
        return $query->where('paralelo_id', $paraleloId);
    }
}
