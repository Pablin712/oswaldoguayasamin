<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuracion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'institucion_id',
        'clave',
        'valor',
        'tipo',
        'categoria',
        'descripcion',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuraciones';

    /**
     * Relación con institución.
     */
    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * Get the typed value based on tipo field.
     *
     * @return mixed
     */
    public function getValorTipificadoAttribute()
    {
        return match($this->tipo) {
            'numero' => (float) $this->valor,
            'booleano' => filter_var($this->valor, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->valor, true),
            default => $this->valor,
        };
    }
}
