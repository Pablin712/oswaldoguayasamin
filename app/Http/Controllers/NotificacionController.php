<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\User;
use App\Http\Requests\NotificacionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Notificacion::where('user_id', $user->id);

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('leida')) {
            $esLeida = $request->leida === '1';
            $query->where('es_leida', $esLeida);
        }

        $notificaciones = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        // Contar no leídas
        $noLeidas = Notificacion::where('user_id', $user->id)
            ->where('es_leida', false)
            ->count();

        return view('comunicacion.notificaciones.index', compact('notificaciones', 'noLeidas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::where('estado', 'activo')
            ->orderBy('name')
            ->get();

        return view('comunicacion.notificaciones.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Si es para múltiples usuarios
            if ($request->filled('usuarios') && is_array($request->usuarios)) {
                foreach ($request->usuarios as $userId) {
                    $notificacion = Notificacion::create([
                        'user_id' => $userId,
                        'tipo' => $data['tipo'],
                        'titulo' => $data['titulo'],
                        'mensaje' => $data['mensaje'],
                        'url' => $data['url'] ?? null,
                        'enviar_email' => $data['enviar_email'] ?? false,
                    ]);

                    // Enviar email si está configurado
                    if ($notificacion->enviar_email && !$notificacion->email_enviado) {
                        $this->enviarEmail($notificacion);
                    }
                }
                $mensaje = 'Notificaciones enviadas exitosamente.';
            } else {
                $notificacion = Notificacion::create($data);

                // Enviar email si está configurado
                if ($notificacion->enviar_email && !$notificacion->email_enviado) {
                    $this->enviarEmail($notificacion);
                }
                $mensaje = 'Notificación creada exitosamente.';
            }

            DB::commit();

            return redirect()
                ->route('notificaciones.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notificacion $notificacion)
    {
        // Verificar que el usuario autenticado sea el dueño
        if ($notificacion->user_id !== Auth::id()) {
            abort(403, 'No autorizado para ver esta notificación.');
        }

        // Marcar como leída
        if (!$notificacion->es_leida) {
            $notificacion->update(['es_leida' => true]);
        }

        return view('comunicacion.notificaciones.show', compact('notificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notificacion $notificacion)
    {
        $usuarios = User::where('estado', 'activo')
            ->orderBy('name')
            ->get();

        return view('comunicacion.notificaciones.edit', compact('notificacion', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificacionRequest $request, Notificacion $notificacion)
    {
        try {
            $notificacion->update($request->validated());

            return redirect()
                ->route('notificaciones.show', $notificacion)
                ->with('success', 'Notificación actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificacion $notificacion)
    {
        // Verificar que el usuario autenticado sea el dueño
        if ($notificacion->user_id !== Auth::id()) {
            abort(403, 'No autorizado para eliminar esta notificación.');
        }

        try {
            $notificacion->delete();

            return redirect()
                ->route('notificaciones.index')
                ->with('success', 'Notificación eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarLeida(Notificacion $notificacion)
    {
        if ($notificacion->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $notificacion->update(['es_leida' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Marcar notificación como no leída
     */
    public function marcarNoLeida(Notificacion $notificacion)
    {
        if ($notificacion->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $notificacion->update(['es_leida' => false]);

        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasLeidas()
    {
        $user = Auth::user();

        Notificacion::where('user_id', $user->id)
            ->where('es_leida', false)
            ->update(['es_leida' => true]);

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'Todas las notificaciones fueron marcadas como leídas.');
    }

    /**
     * Eliminar todas las notificaciones leídas
     */
    public function eliminarLeidas()
    {
        $user = Auth::user();

        Notificacion::where('user_id', $user->id)
            ->where('es_leida', true)
            ->delete();

        return redirect()
            ->route('notificaciones.index')
            ->with('success', 'Notificaciones leídas eliminadas exitosamente.');
    }

    /**
     * Obtener conteo de notificaciones no leídas
     */
    public function conteoNoLeidas()
    {
        $user = Auth::user();

        $count = Notificacion::where('user_id', $user->id)
            ->where('es_leida', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Obtener notificaciones recientes (para badge/dropdown)
     */
    public function recientes()
    {
        $user = Auth::user();

        $notificaciones = Notificacion::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notificaciones);
    }

    /**
     * Enviar email de notificación
     */
    private function enviarEmail(Notificacion $notificacion)
    {
        try {
            $user = $notificacion->user;

            if (!$user || !$user->email) {
                return;
            }

            // Aquí implementarías el envío de email
            // Mail::to($user->email)->send(new NotificacionMail($notificacion));

            $notificacion->update([
                'email_enviado' => true,
                'fecha_envio' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error al enviar email de notificación: ' . $e->getMessage());
        }
    }
}
