<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponenteCalificacion extends Model
{
    protected $table = 'componentes_calificacion';

    protected $fillable = [
        'calificacion_id',
        'nombre',
        'tipo',
        'nota',
        'porcentaje',
        'descripcion',
    ];

    protected function casts(): array
    {
        return [
            'nota' => 'decimal:2',
            'porcentaje' => 'decimal:2',
        ];
    }

    public function calificacion(): BelongsTo
    {
        return $this->belongsTo(Calificacion::class);
    }
}
