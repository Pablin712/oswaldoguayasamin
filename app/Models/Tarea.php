<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarea extends Model
{
    protected $fillable = [
        'docente_id',
        'materia_id',
        'paralelo_id',
        'titulo',
        'descripcion',
        'fecha_asignacion',
        'fecha_entrega',
        'es_calificada',
        'puntaje_maximo',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_entrega' => 'date',
        'es_calificada' => 'boolean',
        'puntaje_maximo' => 'decimal:2',
    ];

    /**
     * Relación con Docente que crea la tarea
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación con Materia
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Relación con Paralelo (opcional)
     */
    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class);
    }

    /**
     * Relación con Archivos adjuntos
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoTarea::class);
    }

    /**
     * Relación con Tareas de Estudiantes
     */
    public function tareaEstudiantes(): HasMany
    {
        return $this->hasMany(TareaEstudiante::class);
    }

    /**
     * Scope para tareas próximas a vencer
     */
    public function scopeProximasAVencer($query, $dias = 7)
    {
        return $query->where('fecha_entrega', '>=', now())
                     ->where('fecha_entrega', '<=', now()->addDays($dias))
                     ->orderBy('fecha_entrega', 'asc');
    }

    /**
     * Scope para tareas vencidas
     */
    public function scopeVencidas($query)
    {
        return $query->where('fecha_entrega', '<', now());
    }

    /**
     * Scope para tareas activas (no vencidas)
     */
    public function scopeActivas($query)
    {
        return $query->where('fecha_entrega', '>=', now());
    }

    /**
     * Scope para tareas de un docente
     */
    public function scopeDeDocente($query, $docenteId)
    {
        return $query->where('docente_id', $docenteId);
    }

    /**
     * Scope para tareas de un paralelo
     */
    public function scopeDeParalelo($query, $paraleloId)
    {
        return $query->where('paralelo_id', $paraleloId);
    }

    /**
     * Verificar si la tarea está vencida
     */
    public function getEstaVencidaAttribute(): bool
    {
        return $this->fecha_entrega < now();
    }

    /**
     * Obtener días restantes para entrega
     */
    public function getDiasRestantesAttribute(): int
    {
        return now()->diffInDays($this->fecha_entrega, false);
    }
}
