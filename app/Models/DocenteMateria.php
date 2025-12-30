<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocenteMateria extends Model
{
    protected $table = 'docente_materia';

    protected $fillable = [
        'docente_id',
        'materia_id',
        'paralelo_id',
        'periodo_academico_id',
        'rol',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function periodoAcademico(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Helper: Calcular total de horas asignadas
    public function totalHorasAsignadas()
    {
        return $this->horarios->sum(function($horario) {
            $inicio = \Carbon\Carbon::parse($horario->hora_inicio);
            $fin = \Carbon\Carbon::parse($horario->hora_fin);
            return $inicio->diffInHours($fin);
        });
    }
}
