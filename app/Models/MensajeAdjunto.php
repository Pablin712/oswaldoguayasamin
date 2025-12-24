<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeAdjunto extends Model
{
    protected $table = 'mensaje_adjuntos';

    public $timestamps = false;

    protected $fillable = [
        'mensaje_id',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_mime',
        'tamanio',
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relación con Mensaje
     */
    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(Mensaje::class);
    }

    /**
     * Obtener el tamaño formateado del archivo
     */
    public function getTamanioFormateadoAttribute(): string
    {
        if (!$this->tamanio) {
            return 'Desconocido';
        }

        $bytes = $this->tamanio;
        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.2f %s", $bytes / pow(1024, $factor), $units[$factor]);
    }
}
