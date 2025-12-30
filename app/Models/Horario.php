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

    // Relaciones
    public function docenteMateria()
    {
        return $this->belongsTo(DocenteMateria::class);
    }

    // Acceso a relaciones a través de docenteMateria
    public function getDocenteAttribute()
    {
        return $this->docenteMateria->docente ?? null;
    }

    public function getMateriaAttribute()
    {
        return $this->docenteMateria->materia ?? null;
    }

    public function getParaleloAttribute()
    {
        return $this->docenteMateria->paralelo ?? null;
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
