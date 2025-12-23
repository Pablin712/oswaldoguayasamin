<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'area',
        'descripcion',
        'color',
        'estado',
    ];

    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_materia')
                    ->withPivot('periodo_academico_id', 'horas_semanales')
                    ->withTimestamps();
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopePorArea($query, $area)
    {
        return $query->where('area', $area);
    }
}
