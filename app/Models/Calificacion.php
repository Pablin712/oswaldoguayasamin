<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'matricula_id',
        'curso_materia_id',
        'parcial_id',
        'docente_id',
        'nota_final',
        'observaciones',
        'fecha_registro',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'nota_final' => 'decimal:2',
            'fecha_registro' => 'date',
        ];
    }

    public function matricula(): BelongsTo
    {
        return $this->belongsTo(Matricula::class);
    }

    public function cursoMateria(): BelongsTo
    {
        return $this->belongsTo(CursoMateria::class);
    }

    public function parcial(): BelongsTo
    {
        return $this->belongsTo(Parcial::class);
    }

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function componentes(): HasMany
    {
        return $this->hasMany(ComponenteCalificacion::class);
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    public function scopePublicadas($query)
    {
        return $query->where('estado', 'publicada');
    }
}
