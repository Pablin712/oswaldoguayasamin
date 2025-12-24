<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aula extends Model
{
    protected $fillable = [
        'nombre',
        'capacidad',
        'edificio',
        'piso',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'capacidad' => 'integer',
            'piso' => 'integer',
        ];
    }

    /**
     * Relación con Horarios
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopePorEdificio($query, $edificio)
    {
        return $query->where('edificio', $edificio);
    }
}
