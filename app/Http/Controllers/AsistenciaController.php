<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Http\Requests\AsistenciaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asistencia::with(['estudiante.user', 'paralelo.curso', 'materia', 'docente.user']);

        // Filtros
        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('estudiante_id')) {
            $query->where('estudiante_id', $request->estudiante_id);
        }

        $asistencias = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(20);

        // Cargar datos para filtros
        $paralelos = Paralelo::with('curso')->get();
        $estudiantes = Estudiante::with('user')->get();

        return view('academico.asistencias.index', compact('asistencias', 'paralelos', 'estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paralelos = Paralelo::with('curso')->get();
        $materias = Materia::all();

        return view('academico.asistencias.create', compact('paralelos', 'materias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AsistenciaRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Si el usuario autenticado es docente, asignar automáticamente
            $user = Auth::user();
            if ($user->docente) {
                $data['docente_id'] = $user->docente->id;
            }

            Asistencia::create($data);

            DB::commit();

            return redirect()
                ->route('asistencias.index')
                ->with('success', 'Asistencia registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al registrar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        $asistencia->load(['estudiante.user', 'paralelo.curso', 'materia', 'docente.user', 'justificaciones']);

        return view('academico.asistencias.show', compact('asistencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        $paralelos = Paralelo::with('curso')->get();
        $materias = Materia::all();
        $estudiantes = Estudiante::with('user')->get();

        return view('academico.asistencias.edit', compact('asistencia', 'paralelos', 'materias', 'estudiantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AsistenciaRequest $request, Asistencia $asistencia)
    {
        try {
            DB::beginTransaction();

            $asistencia->update($request->validated());

            DB::commit();

            return redirect()
                ->route('asistencias.index')
                ->with('success', 'Asistencia actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        try {
            $asistencia->delete();

            return redirect()
                ->route('asistencias.index')
                ->with('success', 'Asistencia eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Registro masivo de asistencia para un paralelo
     */
    public function registroMasivo(Request $request)
    {
        $request->validate([
            'paralelo_id' => 'required|exists:paralelos,id',
            'fecha' => 'required|date',
            'materia_id' => 'nullable|exists:materias,id',
            'asistencias' => 'required|array',
            'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
            'asistencias.*.estado' => 'required|in:presente,ausente,atrasado,justificado',
            'asistencias.*.observaciones' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $docenteId = $user->docente ? $user->docente->id : null;

            foreach ($request->asistencias as $asistenciaData) {
                Asistencia::updateOrCreate(
                    [
                        'estudiante_id' => $asistenciaData['estudiante_id'],
                        'paralelo_id' => $request->paralelo_id,
                        'fecha' => $request->fecha,
                        'materia_id' => $request->materia_id,
                    ],
                    [
                        'docente_id' => $docenteId,
                        'hora' => now()->toTimeString(),
                        'estado' => $asistenciaData['estado'],
                        'observaciones' => $asistenciaData['observaciones'] ?? null,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asistencias registradas exitosamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencias: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de asistencia
     */
    public function estadisticas(Request $request)
    {
        $request->validate([
            'paralelo_id' => 'nullable|exists:paralelos,id',
            'estudiante_id' => 'nullable|exists:estudiantes,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $query = Asistencia::query();

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('estudiante_id')) {
            $query->where('estudiante_id', $request->estudiante_id);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $estadisticas = $query->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->pluck('total', 'estado');

        $total = $estadisticas->sum();
        $porcentajes = [];

        foreach ($estadisticas as $estado => $cantidad) {
            $porcentajes[$estado] = $total > 0 ? round(($cantidad / $total) * 100, 2) : 0;
        }

        return response()->json([
            'total' => $total,
            'por_estado' => $estadisticas,
            'porcentajes' => $porcentajes,
        ]);
    }

    /**
     * Obtener estudiantes de un paralelo para registro de asistencia
     */
    public function cargarEstudiantes(Request $request)
    {
        $request->validate([
            'paralelo_id' => 'required|exists:paralelos,id',
            'fecha' => 'required|date',
            'materia_id' => 'nullable|exists:materias,id',
        ]);

        $paralelo = Paralelo::with(['matriculas.estudiante.user'])->findOrFail($request->paralelo_id);

        $estudiantes = $paralelo->matriculas->map(function ($matricula) use ($request) {
            $asistencia = Asistencia::where('estudiante_id', $matricula->estudiante_id)
                ->where('paralelo_id', $request->paralelo_id)
                ->whereDate('fecha', $request->fecha)
                ->when($request->materia_id, function ($q) use ($request) {
                    $q->where('materia_id', $request->materia_id);
                })
                ->first();

            return [
                'id' => $matricula->estudiante_id,
                'nombre' => $matricula->estudiante->user->name,
                'asistencia' => $asistencia ? [
                    'id' => $asistencia->id,
                    'estado' => $asistencia->estado,
                    'hora' => $asistencia->hora?->format('H:i'),
                    'observaciones' => $asistencia->observaciones,
                ] : null,
            ];
        });

        return response()->json($estudiantes);
    }
}
