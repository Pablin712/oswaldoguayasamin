<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paralelo extends Model
{
    protected $fillable = [
        'curso_id',
        'nombre',
        'cupo_maximo',
        'aula_id',
    ];

    protected function casts(): array
    {
        return [
            'cupo_maximo' => 'integer',
        ];
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function aula(): BelongsTo
    {
        return $this->belongsTo(Aula::class);
    }

    /**
     * Obtener el nombre completo del paralelo (ej: "1ro Básica - A")
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->curso->nombre . ' - ' . $this->nombre;
    }
}
