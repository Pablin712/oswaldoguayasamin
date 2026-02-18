<?php

namespace App\Http\Controllers;

use App\Models\Justificacion;
use App\Models\Asistencia;
use App\Models\Padre;
use App\Http\Requests\JustificacionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JustificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Justificacion::with(['asistencia.estudiante.user', 'padre.user', 'revisadoPor']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('padre_id')) {
            $query->where('padre_id', $request->padre_id);
        }

        // Si es padre, solo ver sus justificaciones
        $user = Auth::user();
        if ($user->padre) {
            $query->where('padre_id', $user->padre->id);
        }

        $justificaciones = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('academico.justificaciones.index', compact('justificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $asistenciaId = $request->get('asistencia_id');
        $asistencia = null;

        if ($asistenciaId) {
            $asistencia = Asistencia::with('estudiante.user')->findOrFail($asistenciaId);
        }

        // Obtener asistencias sin justificar del estudiante
        $user = Auth::user();
        $asistenciasSinJustificar = collect();

        if ($user->padre) {
            $estudiantesIds = $user->padre->estudiantes->pluck('id');
            $asistenciasSinJustificar = Asistencia::whereIn('estudiante_id', $estudiantesIds)
                ->where('estado', 'ausente')
                ->whereDoesntHave('justificaciones', function ($q) {
                    $q->whereIn('estado', ['pendiente', 'aprobada']);
                })
                ->with('estudiante.user')
                ->orderBy('fecha', 'desc')
                ->get();
        }

        return view('academico.justificaciones.create', compact('asistencia', 'asistenciasSinJustificar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JustificacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Si el usuario autenticado es padre, asignar automáticamente
            $user = Auth::user();
            if ($user->padre) {
                $data['padre_id'] = $user->padre->id;
            }

            // Manejar archivo adjunto
            if ($request->hasFile('archivo_adjunto')) {
                $path = $request->file('archivo_adjunto')->store('justificaciones', 'public');
                $data['archivo_adjunto'] = $path;
            }

            Justificacion::create($data);

            DB::commit();

            return redirect()
                ->route('justificaciones.index')
                ->with('success', 'Justificación enviada exitosamente. Será revisada por el personal autorizado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al enviar la justificación: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Justificacion $justificacion)
    {
        // Verificar permisos
        $user = Auth::user();
        if ($user->padre && $justificacion->padre_id !== $user->padre->id) {
            abort(403, 'No autorizado para ver esta justificación.');
        }

        $justificacion->load(['asistencia.estudiante.user', 'asistencia.paralelo.curso', 'padre.user', 'revisadoPor']);

        return view('academico.justificaciones.show', compact('justificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Justificacion $justificacion)
    {
        // Solo se puede editar si está pendiente
        if ($justificacion->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden editar justificaciones pendientes.');
        }

        // Verificar permisos
        $user = Auth::user();
        if ($user->padre && $justificacion->padre_id !== $user->padre->id) {
            abort(403, 'No autorizado para editar esta justificación.');
        }

        $justificacion->load('asistencia.estudiante.user');

        return view('academico.justificaciones.edit', compact('justificacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JustificacionRequest $request, Justificacion $justificacion)
    {
        // Solo se puede editar si está pendiente
        if ($justificacion->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden editar justificaciones pendientes.');
        }

        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Manejar archivo adjunto
            if ($request->hasFile('archivo_adjunto')) {
                // Eliminar archivo anterior si existe
                if ($justificacion->archivo_adjunto) {
                    Storage::disk('public')->delete($justificacion->archivo_adjunto);
                }
                $path = $request->file('archivo_adjunto')->store('justificaciones', 'public');
                $data['archivo_adjunto'] = $path;
            }

            $justificacion->update($data);

            DB::commit();

            return redirect()
                ->route('justificaciones.index')
                ->with('success', 'Justificación actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la justificación: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Justificacion $justificacion)
    {
        // Solo se puede eliminar si está pendiente o rechazada
        if (!in_array($justificacion->estado, ['pendiente', 'rechazada'])) {
            return back()->with('error', 'Solo se pueden eliminar justificaciones pendientes o rechazadas.');
        }

        try {
            // Eliminar archivo adjunto si existe
            if ($justificacion->archivo_adjunto) {
                Storage::disk('public')->delete($justificacion->archivo_adjunto);
            }

            $justificacion->delete();

            return redirect()
                ->route('justificaciones.index')
                ->with('success', 'Justificación eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la justificación: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar una justificación
     */
    public function aprobar(Request $request, Justificacion $justificacion)
    {
        if ($justificacion->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar justificaciones pendientes.');
        }

        try {
            DB::beginTransaction();

            $justificacion->update([
                'estado' => 'aprobada',
                'revisado_por' => Auth::id(),
                'fecha_revision' => now(),
            ]);

            // Actualizar la asistencia a justificado
            $justificacion->asistencia->update([
                'estado' => 'justificado',
            ]);

            DB::commit();

            return redirect()
                ->route('justificaciones.index')
                ->with('success', 'Justificación aprobada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al aprobar la justificación: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar una justificación
     */
    public function rechazar(Request $request, Justificacion $justificacion)
    {
        $request->validate([
            'motivo_rechazo' => 'nullable|string|max:500',
        ]);

        if ($justificacion->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden rechazar justificaciones pendientes.');
        }

        try {
            DB::beginTransaction();

            $justificacion->update([
                'estado' => 'rechazada',
                'revisado_por' => Auth::id(),
                'fecha_revision' => now(),
                'motivo_rechazo' => $request->motivo_rechazo,
            ]);

            DB::commit();

            return redirect()
                ->route('justificaciones.index')
                ->with('success', 'Justificación rechazada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al rechazar la justificación: ' . $e->getMessage());
        }
    }

    /**
     * Obtener justificaciones pendientes
     */
    public function pendientes()
    {
        $justificaciones = Justificacion::with(['asistencia.estudiante.user', 'padre.user'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('academico.justificaciones.pendientes', compact('justificaciones'));
    }
}
