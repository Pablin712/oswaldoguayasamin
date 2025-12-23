<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cedula',
        'telefono',
        'direccion',
        'foto',
        'fecha_nacimiento',
        'estado',
        'ultimo_acceso',
        'intentos_fallidos',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'ultimo_acceso' => 'datetime',
            'intentos_fallidos' => 'integer',
        ];
    }

    // Construir la URL completa de la foto del usuario
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto) {
            return asset('storage/fotos/' . $this->foto);
        }

        return null;
    }

    /**
     * Relación con Docente (uno a uno)
     */
    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class);
    }

    /**
     * Relación con Estudiante (uno a uno)
     */
    public function estudiante(): HasOne
    {
        return $this->hasOne(Estudiante::class);
    }

    /**
     * Relación con Padre (uno a uno)
     */
    public function padre(): HasOne
    {
        return $this->hasOne(Padre::class);
    }
}
