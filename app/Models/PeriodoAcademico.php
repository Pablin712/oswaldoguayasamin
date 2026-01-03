<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodoAcademico extends Model
{
    protected $fillable = [
        'institucion_id',
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $table = 'periodos_academicos';

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function quimestres(): HasMany
    {
        return $this->hasMany(Quimestre::class);
    }

    /**
     * Relación con Institución
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * Relación con Eventos
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

    /**
     * Relación con Horarios
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
