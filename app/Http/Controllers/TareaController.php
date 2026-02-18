<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\ArchivoTarea;
use App\Models\TareaEstudiante;
use App\Models\Materia;
use App\Models\Paralelo;
use App\Models\Estudiante;
use App\Http\Requests\TareaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tarea::with(['docente.user', 'materia', 'paralelo.curso']);

        // Filtros
        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'vencidas') {
                $query->where('fecha_entrega', '<', now());
            } elseif ($request->estado === 'activas') {
                $query->where('fecha_entrega', '>=', now());
            }
        }

        // Si es docente, solo sus tareas
        $user = Auth::user();
        if ($user->docente) {
            $query->where('docente_id', $user->docente->id);
        }

        // Si es estudiante, solo tareas de sus paralelos
        if ($user->estudiante) {
            $paralelosIds = $user->estudiante->matriculas()
                ->where('estado', 'activa')
                ->pluck('paralelo_id');
            $query->whereIn('paralelo_id', $paralelosIds);
        }

        $tareas = $query->orderBy('fecha_entrega', 'desc')
            ->paginate(20);

        $materias = Materia::all();
        $paralelos = Paralelo::with('curso')->get();

        return view('academico.tareas.index', compact('tareas', 'materias', 'paralelos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materias = Materia::all();
        $paralelos = Paralelo::with('curso')->get();

        return view('academico.tareas.create', compact('materias', 'paralelos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TareaRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Si el usuario autenticado es docente, asignar automáticamente
            $user = Auth::user();
            if ($user->docente) {
                $data['docente_id'] = $user->docente->id;
            }

            $tarea = Tarea::create($data);

            // Manejar archivos adjuntos
            if ($request->hasFile('archivos')) {
                foreach ($request->file('archivos') as $archivo) {
                    $path = $archivo->store('tareas', 'public');
                    ArchivoTarea::create([
                        'tarea_id' => $tarea->id,
                        'nombre_archivo' => $archivo->getClientOriginalName(),
                        'ruta_archivo' => $path,
                        'tipo_mime' => $archivo->getMimeType(),
                        'tamanio' => $archivo->getSize(),
                    ]);
                }
            }

            // Crear registros para cada estudiante del paralelo
            if ($request->paralelo_id) {
                $paralelo = Paralelo::with('matriculas.estudiante')->findOrFail($request->paralelo_id);
                foreach ($paralelo->matriculas as $matricula) {
                    if ($matricula->estado === 'activa') {
                        TareaEstudiante::create([
                            'tarea_id' => $tarea->id,
                            'estudiante_id' => $matricula->estudiante_id,
                            'estado' => 'pendiente',
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('tareas.index')
                ->with('success', 'Tarea creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear la tarea: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        $tarea->load(['docente.user', 'materia', 'paralelo.curso', 'archivos', 'tareaEstudiantes.estudiante.user']);

        // Calcular estadísticas
        $totalEstudiantes = $tarea->tareaEstudiantes->count();
        $completadas = $tarea->tareaEstudiantes->where('estado', 'completada')->count();
        $revisadas = $tarea->tareaEstudiantes->where('estado', 'revisada')->count();
        $pendientes = $tarea->tareaEstudiantes->where('estado', 'pendiente')->count();

        $estadisticas = [
            'total' => $totalEstudiantes,
            'completadas' => $completadas,
            'revisadas' => $revisadas,
            'pendientes' => $pendientes,
            'porcentaje_completadas' => $totalEstudiantes > 0 ? round(($completadas / $totalEstudiantes) * 100, 2) : 0,
        ];

        return view('academico.tareas.show', compact('tarea', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        // Verificar que el docente autenticado sea el creador
        $user = Auth::user();
        if ($user->docente && $tarea->docente_id !== $user->docente->id) {
            abort(403, 'No autorizado para editar esta tarea.');
        }

        $materias = Materia::all();
        $paralelos = Paralelo::with('curso')->get();
        $tarea->load('archivos');

        return view('academico.tareas.edit', compact('tarea', 'materias', 'paralelos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TareaRequest $request, Tarea $tarea)
    {
        try {
            DB::beginTransaction();

            $tarea->update($request->validated());

            // Manejar nuevos archivos adjuntos
            if ($request->hasFile('archivos')) {
                foreach ($request->file('archivos') as $archivo) {
                    $path = $archivo->store('tareas', 'public');
                    ArchivoTarea::create([
                        'tarea_id' => $tarea->id,
                        'nombre_archivo' => $archivo->getClientOriginalName(),
                        'ruta_archivo' => $path,
                        'tipo_mime' => $archivo->getMimeType(),
                        'tamanio' => $archivo->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('tareas.show', $tarea)
                ->with('success', 'Tarea actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la tarea: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        try {
            DB::beginTransaction();

            // Eliminar archivos físicos
            foreach ($tarea->archivos as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
                    Storage::disk('public')->delete($archivo->ruta_archivo);
                }
            }

            $tarea->delete();

            DB::commit();

            return redirect()
                ->route('tareas.index')
                ->with('success', 'Tarea eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error al eliminar la tarea: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un archivo de tarea
     */
    public function eliminarArchivo(ArchivoTarea $archivo)
    {
        try {
            if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
                Storage::disk('public')->delete($archivo->ruta_archivo);
            }

            $archivo->delete();

            return back()->with('success', 'Archivo eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Calificar tarea de un estudiante
     */
    public function calificar(Request $request, TareaEstudiante $tareaEstudiante)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:' . ($tareaEstudiante->tarea->puntaje_maximo ?? 10),
            'comentarios_docente' => 'nullable|string|max:1000',
        ]);

        try {
            $tareaEstudiante->update([
                'calificacion' => $request->calificacion,
                'comentarios_docente' => $request->comentarios_docente,
                'estado' => 'revisada',
                'fecha_revision' => now(),
            ]);

            return back()->with('success', 'Tarea calificada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al calificar la tarea: ' . $e->getMessage());
        }
    }

    /**
     * Marcar tarea como completada (estudiante)
     */
    public function completar(Request $request, Tarea $tarea)
    {
        $user = Auth::user();

        if (!$user->estudiante) {
            abort(403, 'Solo los estudiantes pueden completar tareas.');
        }

        $tareaEstudiante = TareaEstudiante::where('tarea_id', $tarea->id)
            ->where('estudiante_id', $user->estudiante->id)
            ->firstOrFail();

        try {
            $tareaEstudiante->update([
                'estado' => 'completada',
                'fecha_completada' => now(),
            ]);

            return back()->with('success', 'Tarea marcada como completada.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al completar la tarea: ' . $e->getMessage());
        }
    }

    /**
     * Obtener tareas próximas a vencer
     */
    public function proximasVencer()
    {
        $tareas = Tarea::query()
            ->where('fecha_entrega', '>', now())
            ->where('fecha_entrega', '<=', now()->addDays(7))
            ->with(['docente.user', 'materia', 'paralelo.curso'])
            ->orderBy('fecha_entrega', 'asc')
            ->get();

        return view('academico.tareas.proximas-vencer', compact('tareas'));
    }
}
