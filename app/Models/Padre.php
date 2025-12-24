<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Padre extends Model
{
    protected $fillable = [
        'user_id',
        'ocupacion',
        'lugar_trabajo',
        'telefono_trabajo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_padre')
                    ->withPivot('parentesco', 'es_principal')
                    ->withTimestamps();
    }

    /**
     * Relación con Justificaciones
     */
    public function justificaciones(): HasMany
    {
        return $this->hasMany(Justificacion::class);
    }

    /**
     * Obtener el nombre completo del padre desde user
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name;
    }
}
