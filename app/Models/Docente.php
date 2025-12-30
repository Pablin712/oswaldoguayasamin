<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    protected $fillable = [
        'user_id',
        'codigo_docente',
        'titulo_profesional',
        'especialidad',
        'fecha_ingreso',
        'tipo_contrato',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con Asistencias que registra
     */
    public function asistenciasRegistradas(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    /**
     * Relación con Tareas creadas
     */
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }

    /**
     * Relación con Horarios asignados
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Relación con asignaciones de materias
     */
    public function docenteMaterias(): HasMany
    {
        return $this->hasMany(DocenteMateria::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Obtener el nombre completo del docente desde user
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name;
    }
}
