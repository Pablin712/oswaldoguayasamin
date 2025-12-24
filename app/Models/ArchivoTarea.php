<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoTarea extends Model
{
    protected $table = 'archivos_tarea';

    public $timestamps = false;

    protected $fillable = [
        'tarea_id',
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
     * Relación con Tarea
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class);
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
