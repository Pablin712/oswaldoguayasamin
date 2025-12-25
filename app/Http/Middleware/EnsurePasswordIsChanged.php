<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    /**
     * Handle an incoming request.
     *
     * Verifica si el usuario debe cambiar su contraseña.
     * Si la contraseña actual es igual a su cédula, se le fuerza a cambiarla.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si el usuario no está autenticado o está en la ruta de cambio de contraseña
        if (!$user || $request->is('password/change')) {
            return $next($request);
        }

        // Verificar si la contraseña actual es igual a la cédula (contraseña inicial)
        if (Hash::check($user->cedula, $user->password)) {
            // Guardar en sesión el mensaje de advertencia
            session()->flash('password_change_required', true);

            // Si no está en la ruta de cambio de contraseña, redirigir
            if (!$request->is('password/change')) {
                return redirect()->route('password.change')
                    ->with('warning', 'Por seguridad, debes cambiar tu contraseña predeterminada antes de continuar.');
            }
        }

        return $next($request);
    }
}
