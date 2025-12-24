<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'paralelo_id',
        'materia_id',
        'docente_id',
        'aula_id',
        'periodo_academico_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    // Relaciones
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    // Scopes
    public function scopeDelParalelo($query, $paraleloId)
    {
        return $query->where('paralelo_id', $paraleloId);
    }

    public function scopeDelDocente($query, $docenteId)
    {
        return $query->where('docente_id', $docenteId);
    }

    public function scopeDelAula($query, $aulaId)
    {
        return $query->where('aula_id', $aulaId);
    }

    public function scopePorDia($query, $dia)
    {
        return $query->where('dia_semana', $dia);
    }

    public function scopeDelPeriodo($query, $periodoId)
    {
        return $query->where('periodo_academico_id', $periodoId);
    }

    public function scopeOrdenadoPorHora($query)
    {
        return $query->orderBy('hora_inicio');
    }

    // Accessors
    public function getDuracionMinutosAttribute()
    {
        $inicio = \Carbon\Carbon::parse($this->hora_inicio);
        $fin = \Carbon\Carbon::parse($this->hora_fin);
        return $inicio->diffInMinutes($fin);
    }

    public function getHorarioFormateadoAttribute()
    {
        return substr($this->hora_inicio, 0, 5) . ' - ' . substr($this->hora_fin, 0, 5);
    }

    // Métodos de utilidad
    public static function getDiasSemana()
    {
        return ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
    }

    public function seSuperpone($diaSemanaNuevo, $horaInicioNueva, $horaFinNueva)
    {
        if ($this->dia_semana !== $diaSemanaNuevo) {
            return false;
        }

        // Verifica si hay superposición de horarios
        return !(
            $horaFinNueva <= $this->hora_inicio ||
            $horaInicioNueva >= $this->hora_fin
        );
    }
}
