<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopePorArea($query, $area)
    {
        return $query->where('area', $area);
    }
}
