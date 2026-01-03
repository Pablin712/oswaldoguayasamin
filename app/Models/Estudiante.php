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
        'conteo_matriculas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'conteo_matriculas' => 'array',
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

    /**
     * Relación con Confirmaciones de Eventos
     */
    public function eventosConfirmados(): HasMany
    {
        return $this->hasMany(EventoConfirmacion::class);
    }

    /**
     * Relación con Solicitudes de Matrícula
     */
    public function solicitudesMatricula(): HasMany
    {
        return $this->hasMany(SolicitudMatricula::class);
    }

    /**
     * Relación con Matrículas
     */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
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

    /**
     * Incrementar conteo de matrículas para un curso
     */
    public function incrementarMatricula(int $cursoId): void
    {
        $conteo = $this->conteo_matriculas ?? [];
        $conteo[$cursoId] = ($conteo[$cursoId] ?? 0) + 1;
        $this->update(['conteo_matriculas' => $conteo]);
    }

    /**
     * Obtener cantidad de matrículas en un curso específico
     */
    public function getConteoMatriculasEnCurso(int $cursoId): int
    {
        $conteo = $this->conteo_matriculas ?? [];
        return $conteo[$cursoId] ?? 0;
    }

    /**
     * Verificar si puede matricularse en un curso (máximo 2 matrículas)
     */
    public function puedeMatricularseEn(int $cursoId): bool
    {
        return $this->getConteoMatriculasEnCurso($cursoId) < 2;
    }
}
