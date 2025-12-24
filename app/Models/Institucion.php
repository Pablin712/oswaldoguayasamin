<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institucion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'codigo_amie',
        'logo',
        'tipo',
        'nivel',
        'jornada',
        'provincia',
        'ciudad',
        'canton',
        'parroquia',
        'direccion',
        'telefono',
        'email',
        'sitio_web',
        'rector',
        'vicerrector',
        'inspector',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instituciones';

    /**
     * Relación con configuraciones.
     */
    public function configuraciones(): HasMany
    {
        return $this->hasMany(Configuracion::class);
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        return null;
    }
}
