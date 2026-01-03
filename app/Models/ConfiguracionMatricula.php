<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionMatricula extends Model
{
    protected $table = 'configuracion_matriculas';

    protected $fillable = [
        'institucion_id',
        'tipo_institucion',
        'monto_primera_matricula',
        'monto_segunda_matricula',
    ];

    protected function casts(): array
    {
        return [
            'monto_primera_matricula' => 'decimal:2',
            'monto_segunda_matricula' => 'decimal:2',
        ];
    }

    /**
     * Relación con Institución
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * Obtener el monto según el tipo de matrícula
     */
    public function getMontoByTipo(string $tipo): float
    {
        return $tipo === 'primera'
            ? $this->monto_primera_matricula
            : $this->monto_segunda_matricula;
    }

    /**
     * Verificar si la matrícula es gratuita
     */
    public function isGratuita(string $tipo): bool
    {
        return $this->getMontoByTipo($tipo) == 0;
    }
}
