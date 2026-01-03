<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OrdenPago extends Model
{
    protected $table = 'ordenes_pago';

    protected $fillable = [
        'matricula_id',
        'codigo_orden',
        'monto',
        'tipo_pago',
        'estado',
        'comprobante_path',
        'fecha_pago',
        'observaciones',
        'revisado_por',
        'fecha_revision',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha_pago' => 'datetime',
            'fecha_revision' => 'datetime',
        ];
    }

    /**
     * Boot method para generar código automático
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->codigo_orden)) {
                $model->codigo_orden = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relación con Matrícula
     */
    public function matricula(): BelongsTo
    {
        return $this->belongsTo(Matricula::class);
    }

    /**
     * Relación con Usuario Revisor
     */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Scope para órdenes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para órdenes aprobadas
     */
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    /**
     * Scope para órdenes con comprobante
     */
    public function scopeConComprobante($query)
    {
        return $query->whereNotNull('comprobante_path');
    }

    /**
     * Verificar si la orden es gratuita
     */
    public function isGratuita(): bool
    {
        return $this->monto == 0;
    }

    /**
     * Verificar si tiene comprobante adjunto
     */
    public function tieneComprobante(): bool
    {
        return !empty($this->comprobante_path);
    }
}
