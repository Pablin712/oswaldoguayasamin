<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $fillable = [
        'user_id',
        'codigo_estudiante',
        'fecha_ingreso',
        'tipo_sangre',
        'alergias',
        'contacto_emergencia',
        'telefono_emergencia',
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

    public function padres(): BelongsToMany
    {
        return $this->belongsToMany(Padre::class, 'estudiante_padre')
                    ->withPivot('parentesco', 'es_principal')
                    ->withTimestamps();
    }

    /**
     * Relación con Asistencias
     */
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    /**
     * Relación con Tareas asignadas
     */
    public function tareaEstudiantes(): HasMany
    {
        return $this->hasMany(TareaEstudiante::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Obtener el nombre completo del estudiante desde user
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name;
    }
}
