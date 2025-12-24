<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo_academico_id',
        'tipo',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'ubicacion',
        'requiere_confirmacion',
        'es_publico',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'requiere_confirmacion' => 'boolean',
        'es_publico' => 'boolean',
    ];

    // Relaciones
    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }

    public function paralelos()
    {
        return $this->belongsToMany(Paralelo::class, 'evento_curso')
            ->withTimestamps();
    }

    public function confirmaciones()
    {
        return $this->hasMany(EventoConfirmacion::class);
    }

    // Scopes
    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>=', now()->toDateString())
            ->orderBy('fecha_inicio');
    }

    public function scopePasados($query)
    {
        return $query->where('fecha_inicio', '<', now()->toDateString())
            ->orderBy('fecha_inicio', 'desc');
    }

    public function scopeEnCurso($query)
    {
        return $query->where('fecha_inicio', '<=', now()->toDateString())
            ->where(function ($q) {
                $q->whereNull('fecha_fin')
                    ->orWhere('fecha_fin', '>=', now()->toDateString());
            });
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePublicos($query)
    {
        return $query->where('es_publico', true);
    }

    public function scopeDelPeriodo($query, $periodoId)
    {
        return $query->where('periodo_academico_id', $periodoId);
    }

    public function scopeDelParalelo($query, $paraleloId)
    {
        return $query->whereHas('paralelos', function ($q) use ($paraleloId) {
            $q->where('paralelos.id', $paraleloId);
        });
    }

    // Accessors
    public function getEstaEnCursoAttribute()
    {
        $hoy = now()->toDateString();
        $finalizacion = $this->fecha_fin ?? $this->fecha_inicio;

        return $this->fecha_inicio <= $hoy && $finalizacion >= $hoy;
    }

    public function getDuracionDiasAttribute()
    {
        if (!$this->fecha_fin) {
            return 1;
        }

        return $this->fecha_inicio->diffInDays($this->fecha_fin) + 1;
    }

    public function getPorcentajeConfirmacionAttribute()
    {
        if (!$this->requiere_confirmacion) {
            return null;
        }

        $total = $this->confirmaciones()->count();
        if ($total === 0) {
            return 0;
        }

        $confirmados = $this->confirmaciones()->where('confirmado', true)->count();
        return round(($confirmados / $total) * 100, 2);
    }
}
