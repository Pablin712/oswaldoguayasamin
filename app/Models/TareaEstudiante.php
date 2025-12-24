<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaEstudiante extends Model
{
    protected $table = 'tarea_estudiante';

    protected $fillable = [
        'tarea_id',
        'estudiante_id',
        'estado',
        'fecha_completada',
        'calificacion',
        'comentarios_docente',
        'fecha_revision',
    ];

    protected $casts = [
        'fecha_completada' => 'datetime',
        'fecha_revision' => 'datetime',
        'calificacion' => 'decimal:2',
    ];

    /**
     * Relación con Tarea
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class);
    }

    /**
     * Relación con Estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para tareas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para tareas completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    /**
     * Scope para tareas revisadas
     */
    public function scopeRevisadas($query)
    {
        return $query->where('estado', 'revisada');
    }

    /**
     * Scope para tareas de un estudiante
     */
    public function scopeDeEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Verificar si la tarea fue completada a tiempo
     */
    public function getCompletadaATiempoAttribute(): ?bool
    {
        if (!$this->fecha_completada) {
            return null;
        }

        return $this->fecha_completada <= $this->tarea->fecha_entrega;
    }
}
