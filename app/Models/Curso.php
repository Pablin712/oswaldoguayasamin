<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    protected $fillable = [
        'nombre',
        'nivel',
        'orden',
        'descripcion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'orden' => 'integer',
        ];
    }

    public function paralelos(): HasMany
    {
        return $this->hasMany(Paralelo::class);
    }

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'curso_materia')
                    ->withPivot('periodo_academico_id', 'horas_semanales')
                    ->withTimestamps();
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}
