<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocenteMateria extends Model
{
    protected $table = 'docente_materia';

    protected $fillable = [
        'docente_id',
        'curso_materia_id',
        'paralelo_id',
        'periodo_academico_id',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function cursoMateria(): BelongsTo
    {
        return $this->belongsTo(CursoMateria::class);
    }

    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function periodoAcademico(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }
}
