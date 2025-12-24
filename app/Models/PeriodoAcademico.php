<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodoAcademico extends Model
{
    protected $fillable = [
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
     * Relación con Eventos
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
