<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'docente_materia_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    // Relaciones directas
    public function docenteMateria()
    {
        return $this->belongsTo(DocenteMateria::class);
    }

    // Relaciones a través de docenteMateria usando hasOneThrough
    public function paralelo()
    {
        return $this->hasOneThrough(
            Paralelo::class,
            DocenteMateria::class,
            'id',                  // Foreign key en docente_materia
            'id',                  // Foreign key en paralelos
            'docente_materia_id',  // Local key en horarios
            'paralelo_id'          // Local key en docente_materia
        );
    }

    public function docente()
    {
        return $this->hasOneThrough(
            Docente::class,
            DocenteMateria::class,
            'id',                  // Foreign key en docente_materia
            'id',                  // Foreign key en docentes
            'docente_materia_id',  // Local key en horarios
            'docente_id'           // Local key en docente_materia
        );
    }

    public function materia()
    {
        return $this->hasOneThrough(
            Materia::class,
            DocenteMateria::class,
            'id',                  // Foreign key en docente_materia
            'id',                  // Foreign key en materias
            'docente_materia_id',  // Local key en horarios
            'materia_id'           // Local key en docente_materia
        );
    }

    // Para aula, usamos un accessor porque está a 3 niveles de profundidad
    public function getAulaAttribute()
    {
        return $this->paralelo->aula ?? null;
    }

    // Scopes
    public function scopeDelParalelo($query, $paraleloId)
    {
        return $query->whereHas('docenteMateria', function($q) use ($paraleloId) {
            $q->where('paralelo_id', $paraleloId);
        });
    }

    public function scopeDelDocente($query, $docenteId)
    {
        return $query->whereHas('docenteMateria', function($q) use ($docenteId) {
            $q->where('docente_id', $docenteId);
        });
    }

    public function scopeDelAula($query, $aulaId)
    {
        return $query->whereHas('docenteMateria.paralelo', function($q) use ($aulaId) {
            $q->where('aula_id', $aulaId);
        });
    }

    public function scopePorDia($query, $dia)
    {
        return $query->where('dia_semana', $dia);
    }

    public function scopeDelPeriodo($query, $periodoId)
    {
        return $query->whereHas('docenteMateria', function($q) use ($periodoId) {
            $q->where('periodo_academico_id', $periodoId);
        });
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
        return ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
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
