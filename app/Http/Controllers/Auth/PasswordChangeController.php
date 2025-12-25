<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordChangeController extends Controller
{
    /**
     * Display the password change form.
     */
    public function create(): View
    {
        return view('auth.change-password');
    }

    /**
     * Handle an incoming password change request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required' => 'Debes ingresar una nueva contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Actualizar la contraseña
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard')->with('status', 'Contraseña actualizada exitosamente.');
    }
}
