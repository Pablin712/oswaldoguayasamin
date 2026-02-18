<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaAcceso extends Model
{
    use HasFactory;

    protected $table = 'auditoria_accesos';

    // Deshabilitar updated_at ya que solo tiene created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'accion',
        'tabla_afectada',
        'registro_id',
        'ip_address',
        'user_agent',
        'datos_anteriores',
        'datos_nuevos',
        'descripcion',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'created_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias para consistencia con otras partes del código
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    public function scopeDeTabla($query, $tabla)
    {
        return $query->where('tabla_afectada', $tabla);
    }

    public function scopeDeRegistro($query, $tabla, $registroId)
    {
        return $query->where('tabla_afectada', $tabla)
                     ->where('registro_id', $registroId);
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    public function scopeRecientes($query, $limite = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limite);
    }

    public function scopePorIp($query, $ip)
    {
        return $query->where('ip_address', $ip);
    }

    // Métodos estáticos para registrar auditoría
    public static function registrarAccion($accion, $tabla = null, $registroId = null, $datosAnteriores = null, $datosNuevos = null, $descripcion = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'accion' => $accion,
            'tabla_afectada' => $tabla,
            'registro_id' => $registroId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'datos_anteriores' => $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'descripcion' => $descripcion,
        ]);
    }

    public static function registrarLogin()
    {
        return self::registrarAccion('login', 'users', auth()->id(), null, null, 'Inicio de sesión');
    }

    public static function registrarLogout()
    {
        return self::registrarAccion('logout', 'users', auth()->id(), null, null, 'Cierre de sesión');
    }

    public static function registrarCreacion($tabla, $registroId, $datos, $descripcion = null)
    {
        return self::registrarAccion('create', $tabla, $registroId, null, $datos, $descripcion ?? "Creación de registro en {$tabla}");
    }

    public static function registrarActualizacion($tabla, $registroId, $datosAnteriores, $datosNuevos, $descripcion = null)
    {
        return self::registrarAccion('update', $tabla, $registroId, $datosAnteriores, $datosNuevos, $descripcion ?? "Actualización de registro en {$tabla}");
    }

    public static function registrarEliminacion($tabla, $registroId, $datos, $descripcion = null)
    {
        return self::registrarAccion('delete', $tabla, $registroId, $datos, null, $descripcion ?? "Eliminación de registro en {$tabla}");
    }

    // Accessors
    public function getTieneModificacionesAttribute()
    {
        return !empty($this->datos_anteriores) || !empty($this->datos_nuevos);
    }

    public function getCambiosAttribute()
    {
        if (!$this->tiene_modificaciones) {
            return [];
        }

        $cambios = [];
        $anteriores = $this->datos_anteriores ?? [];
        $nuevos = $this->datos_nuevos ?? [];

        foreach ($nuevos as $campo => $valorNuevo) {
            $valorAnterior = $anteriores[$campo] ?? null;
            if ($valorAnterior !== $valorNuevo) {
                $cambios[$campo] = [
                    'anterior' => $valorAnterior,
                    'nuevo' => $valorNuevo,
                ];
            }
        }

        return $cambios;
    }
}
