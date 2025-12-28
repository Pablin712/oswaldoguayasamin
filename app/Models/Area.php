<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    /**
     * Relación: Un área tiene muchas materias
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class);
    }

    /**
     * Scope para filtrar áreas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }
}
