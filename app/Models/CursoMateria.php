<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CursoMateria extends Model
{
    protected $fillable = [
        'curso_id',
        'materia_id',
        'periodo_academico_id',
        'horas_semanales',
    ];

    protected $table = 'curso_materia';

    protected function casts(): array
    {
        return [
            'horas_semanales' => 'integer',
        ];
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function periodoAcademico(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }
}
