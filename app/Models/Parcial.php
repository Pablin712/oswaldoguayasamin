<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parcial extends Model
{
    protected $fillable = [
        'quimestre_id',
        'nombre',
        'numero',
        'fecha_inicio',
        'fecha_fin',
        'permite_edicion',
    ];

    protected $table = 'parciales';

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'numero' => 'integer',
            'permite_edicion' => 'boolean',
        ];
    }

    public function quimestre(): BelongsTo
    {
        return $this->belongsTo(Quimestre::class);
    }

    public function scopeEditables($query)
    {
        return $query->where('permite_edicion', true);
    }
}
