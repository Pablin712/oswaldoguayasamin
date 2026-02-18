<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\MensajeAdjunto;
use App\Models\MensajeDestinatario;
use App\Models\User;
use App\Http\Requests\MensajeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tipo = $request->get('tipo', 'recibidos');

        if ($tipo === 'enviados') {
            $query = Mensaje::where('remitente_id', $user->id)
                ->with(['destinatario', 'adjuntos']);
        } else {
            // Mensajes recibidos (individuales o parte de masivos)
            $query = Mensaje::where(function ($q) use ($user) {
                $q->where('destinatario_id', $user->id)
                  ->orWhereHas('destinatarios', function ($q2) use ($user) {
                      $q2->where('destinatario_id', $user->id);
                  });
            })->with(['remitente', 'adjuntos']);
        }

        // Filtros
        if ($request->filled('tipo_mensaje')) {
            $query->where('tipo', $request->tipo_mensaje);
        }

        if ($request->filled('leido')) {
            if ($tipo === 'recibidos') {
                $esLeido = $request->leido === '1';
                $query->where(function ($q) use ($user, $esLeido) {
                    $q->where(function ($q2) use ($user, $esLeido) {
                        $q2->where('destinatario_id', $user->id)
                           ->where('es_leido', $esLeido);
                    })->orWhereHas('destinatarios', function ($q2) use ($user, $esLeido) {
                        $q2->where('destinatario_id', $user->id)
                           ->where('es_leido', $esLeido);
                    });
                });
            }
        }

        $mensajes = $query->orderBy('fecha_envio', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('comunicacion.mensajes.index', compact('mensajes', 'tipo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinatarioId = $request->get('destinatario_id');
        $destinatario = null;

        if ($destinatarioId) {
            $destinatario = User::findOrFail($destinatarioId);
        }

        $usuarios = User::where('id', '!=', Auth::id())
            ->where('estado', 'activo')
            ->orderBy('name')
            ->get();

        return view('comunicacion.mensajes.create', compact('usuarios', 'destinatario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MensajeRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['remitente_id'] = Auth::id();
            $data['fecha_envio'] = $request->programado_para ?? now();

            // Determinar tipo de mensaje
            if ($request->filled('destinatarios') && count($request->destinatarios) > 1) {
                $data['tipo'] = 'masivo';
                $data['destinatario_id'] = null;
            } elseif ($request->filled('destinatario_id')) {
                $data['tipo'] = 'individual';
            } else {
                $data['tipo'] = 'anuncio';
                $data['destinatario_id'] = null;
            }

            $mensaje = Mensaje::create($data);

            // Manejar archivos adjuntos
            if ($request->hasFile('adjuntos')) {
                foreach ($request->file('adjuntos') as $archivo) {
                    $path = $archivo->store('mensajes', 'public');
                    MensajeAdjunto::create([
                        'mensaje_id' => $mensaje->id,
                        'nombre_archivo' => $archivo->getClientOriginalName(),
                        'ruta_archivo' => $path,
                        'tipo_mime' => $archivo->getMimeType(),
                        'tamanio' => $archivo->getSize(),
                    ]);
                }
            }

            // Si es masivo, crear registros para cada destinatario
            if ($data['tipo'] === 'masivo' && $request->filled('destinatarios')) {
                foreach ($request->destinatarios as $destinatarioId) {
                    MensajeDestinatario::create([
                        'mensaje_id' => $mensaje->id,
                        'destinatario_id' => $destinatarioId,
                        'es_leido' => false,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('mensajes.index', ['tipo' => 'enviados'])
                ->with('success', 'Mensaje enviado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al enviar el mensaje: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mensaje $mensaje)
    {
        $user = Auth::user();

        // Verificar que el usuario tiene acceso al mensaje
        $tieneAcceso = $mensaje->remitente_id === $user->id
            || $mensaje->destinatario_id === $user->id
            || $mensaje->destinatarios()->where('destinatario_id', $user->id)->exists();

        if (!$tieneAcceso) {
            abort(403, 'No autorizado para ver este mensaje.');
        }

        // Marcar como leído si es el destinatario
        if ($mensaje->destinatario_id === $user->id && !$mensaje->es_leido) {
            $mensaje->update([
                'es_leido' => true,
                'fecha_lectura' => now(),
            ]);
        } elseif ($mensaje->tipo === 'masivo') {
            $destinatario = $mensaje->destinatarios()->where('destinatario_id', $user->id)->first();
            if ($destinatario && !$destinatario->es_leido) {
                $destinatario->update([
                    'es_leido' => true,
                    'fecha_lectura' => now(),
                ]);
            }
        }

        $mensaje->load(['remitente', 'destinatario', 'adjuntos', 'destinatarios.destinatario']);

        return view('comunicacion.mensajes.show', compact('mensaje'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mensaje $mensaje)
    {
        // Solo el remitente puede editar y solo si no ha sido enviado
        if ($mensaje->remitente_id !== Auth::id()) {
            abort(403, 'No autorizado para editar este mensaje.');
        }

        if ($mensaje->fecha_envio && $mensaje->fecha_envio <= now()) {
            return back()->with('error', 'No se pueden editar mensajes ya enviados.');
        }

        $usuarios = User::where('id', '!=', Auth::id())
            ->where('estado', 'activo')
            ->orderBy('name')
            ->get();

        $mensaje->load('destinatarios');

        return view('comunicacion.mensajes.edit', compact('mensaje', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MensajeRequest $request, Mensaje $mensaje)
    {
        if ($mensaje->fecha_envio && $mensaje->fecha_envio <= now()) {
            return back()->with('error', 'No se pueden editar mensajes ya enviados.');
        }

        try {
            DB::beginTransaction();

            $mensaje->update($request->validated());

            // Actualizar destinatarios si es masivo
            if ($mensaje->tipo === 'masivo' && $request->filled('destinatarios')) {
                $mensaje->destinatarios()->delete();
                foreach ($request->destinatarios as $destinatarioId) {
                    MensajeDestinatario::create([
                        'mensaje_id' => $mensaje->id,
                        'destinatario_id' => $destinatarioId,
                        'es_leido' => false,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('mensajes.show', $mensaje)
                ->with('success', 'Mensaje actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el mensaje: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mensaje $mensaje)
    {
        // Solo el remitente puede eliminar
        if ($mensaje->remitente_id !== Auth::id()) {
            abort(403, 'No autorizado para eliminar este mensaje.');
        }

        try {
            DB::beginTransaction();

            // Eliminar archivos adjuntos
            foreach ($mensaje->adjuntos as $adjunto) {
                if (Storage::disk('public')->exists($adjunto->ruta_archivo)) {
                    Storage::disk('public')->delete($adjunto->ruta_archivo);
                }
            }

            $mensaje->delete();

            DB::commit();

            return redirect()
                ->route('mensajes.index')
                ->with('success', 'Mensaje eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al eliminar el mensaje: ' . $e->getMessage());
        }
    }

    /**
     * Marcar mensaje como leído
     */
    public function marcarLeido(Mensaje $mensaje)
    {
        $user = Auth::user();

        if ($mensaje->destinatario_id === $user->id) {
            $mensaje->update([
                'es_leido' => true,
                'fecha_lectura' => now(),
            ]);
        } elseif ($mensaje->tipo === 'masivo') {
            $mensaje->destinatarios()
                ->where('destinatario_id', $user->id)
                ->update([
                    'es_leido' => true,
                    'fecha_lectura' => now(),
                ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Marcar mensaje como no leído
     */
    public function marcarNoLeido(Mensaje $mensaje)
    {
        $user = Auth::user();

        if ($mensaje->destinatario_id === $user->id) {
            $mensaje->update([
                'es_leido' => false,
                'fecha_lectura' => null,
            ]);
        } elseif ($mensaje->tipo === 'masivo') {
            $mensaje->destinatarios()
                ->where('destinatario_id', $user->id)
                ->update([
                    'es_leido' => false,
                    'fecha_lectura' => null,
                ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Obtener conteo de mensajes no leídos
     */
    public function conteoNoLeidos()
    {
        $user = Auth::user();

        $count = Mensaje::where(function ($q) use ($user) {
            $q->where('destinatario_id', $user->id)
              ->where('es_leido', false);
        })->orWhereHas('destinatarios', function ($q) use ($user) {
            $q->where('destinatario_id', $user->id)
              ->where('es_leido', false);
        })->count();

        return response()->json(['count' => $count]);
    }
}
