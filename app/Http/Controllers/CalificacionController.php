<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\ComponenteCalificacion;
use App\Models\Matricula;
use App\Models\CursoMateria;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\PeriodoAcademico;
use App\Models\Quimestre;
use App\Models\Parcial;
use App\Models\Paralelo;
use App\Models\DocenteMateria;
use App\Http\Requests\CalificacionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::any(['ver calificaciones', 'gestionar calificaciones']);

        // Obtener la institución del usuario autenticado
        $user = Auth::user();
        $institucionId = $user->institucion_id;

        // Obtener período académico actual
        $periodoActual = PeriodoAcademico::where('institucion_id', $institucionId)
            ->where('estado', 'activo')
            ->first();

        // Obtener todos los períodos para el selector
        $periodos = PeriodoAcademico::where('institucion_id', $institucionId)
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // Obtener quimestre actual si existe período activo
        $quimestreActual = null;
        $quimestres = collect();
        if ($periodoActual) {
            // Obtener quimestre actual basado en fechas
            $quimestreActual = Quimestre::where('periodo_academico_id', $periodoActual->id)
                ->where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->first();

            // Si no hay quimestre activo por fechas, obtener el más reciente
            if (!$quimestreActual) {
                $quimestreActual = Quimestre::where('periodo_academico_id', $periodoActual->id)
                    ->orderBy('numero', 'desc')
                    ->first();
            }

            $quimestres = Quimestre::where('periodo_academico_id', $periodoActual->id)
                ->orderBy('numero')
                ->get();
        }

        // Obtener parcial actual si existe quimestre activo
        $parcialActual = null;
        $parciales = collect();
        if ($quimestreActual) {
            // Obtener parcial actual basado en fechas
            $parcialActual = Parcial::where('quimestre_id', $quimestreActual->id)
                ->where('fecha_inicio', '<=', now())
                ->where('fecha_fin', '>=', now())
                ->first();

            // Si no hay parcial activo por fechas, obtener el más reciente
            if (!$parcialActual) {
                $parcialActual = Parcial::where('quimestre_id', $quimestreActual->id)
                    ->orderBy('numero', 'desc')
                    ->first();
            }

            $parciales = Parcial::where('quimestre_id', $quimestreActual->id)
                ->orderBy('numero')
                ->get();
        }

        // Obtener paralelos según el rol (con información del curso para el select)
        $cursosParalelos = [];
        if ($periodoActual) {
            if ($user->hasRole('profesor')) {
                $docenteId = $user->docente->id;
                $paralelos = Paralelo::where('periodo_academico_id', $periodoActual->id)
                    ->whereHas('cursoMaterias.docenteMaterias', function ($query) use ($docenteId) {
                        $query->where('docente_id', $docenteId);
                    })
                    ->with('curso')
                    ->get();
            } else {
                $paralelos = Paralelo::where('periodo_academico_id', $periodoActual->id)
                    ->with('curso')
                    ->get();
            }

            // Formatear para el searchable-select: "Curso - Paralelo"
            $cursosParalelos = $paralelos->map(function($paralelo) {
                return [
                    'id' => $paralelo->id,
                    'name' => $paralelo->curso->nombre . ' - ' . $paralelo->nombre
                ];
            })->toArray();
        }

        return view('academico.calificaciones.index', compact(
            'periodos',
            'periodoActual',
            'quimestres',
            'quimestreActual',
            'parciales',
            'parcialActual',
            'cursosParalelos'
        ));
    }

    /**
     * Cargar contexto para filtros
     */
    public function cargarContexto(Request $request)
    {
        $user = Auth::user();
        $institucionId = $user->institucion_id;
        $tipo = $request->tipo;

        switch ($tipo) {
            case 'quimestres':
                $periodoId = $request->periodo_id;
                $quimestres = Quimestre::where('periodo_academico_id', $periodoId)
                    ->orderBy('numero')
                    ->get();
                return response()->json($quimestres);

            case 'parciales':
                $quimestreId = $request->quimestre_id;
                $parciales = Parcial::where('quimestre_id', $quimestreId)
                    ->orderBy('numero')
                    ->get();
                return response()->json($parciales);

            case 'paralelos':
                $periodoId = $request->periodo_id;

                // Si es docente, solo mostrar sus paralelos
                if ($user->hasRole('profesor')) {
                    $docenteId = $user->docente->id;
                    $paralelos = Paralelo::where('periodo_academico_id', $periodoId)
                    ->whereHas('cursoMaterias.docenteMaterias', function ($query) use ($docenteId) {
                        $query->where('docente_id', $docenteId);
                    })
                    ->with('curso')
                    ->get();
                } else {
                    // Administradores ven todos los paralelos
                    $paralelos = Paralelo::where('periodo_academico_id', $periodoId)
                    ->with('curso')
                    ->get();
                }

                return response()->json($paralelos);

            case 'materias':
                $paraleloId = $request->paralelo_id;
                $parcialId = $request->parcial_id;

                // Obtener el paralelo para saber el curso_id y periodo_academico_id
                $paralelo = Paralelo::find($paraleloId);

                if (!$paralelo) {
                    return response()->json([]);
                }

                // Si es docente, solo mostrar sus materias
                if ($user->hasRole('profesor')) {
                    $docenteId = $user->docente->id;

                    // Obtener las materias que el docente enseña en este curso y período
                    $materias = CursoMateria::where('curso_id', $paralelo->curso_id)
                        ->where('periodo_academico_id', $paralelo->periodo_academico_id)
                        ->whereHas('docenteMaterias', function ($query) use ($docenteId, $parcialId) {
                            $query->where('docente_id', $docenteId)
                                  ->where('parcial_id', $parcialId);
                        })
                        ->with('materia')
                        ->get();
                } else {
                    // Administradores ven todas las materias del curso
                    $materias = CursoMateria::where('curso_id', $paralelo->curso_id)
                        ->where('periodo_academico_id', $paralelo->periodo_academico_id)
                        ->with('materia')
                        ->get();
                }

                return response()->json($materias);

            default:
                return response()->json(['error' => 'Tipo no válido'], 400);
        }
    }

    /**
     * Cargar estudiantes del paralelo para registro de calificaciones
     */
    public function cargarEstudiantes(Request $request)
    {
        $paraleloId = $request->paralelo_id;
        $cursoMateriaId = $request->curso_materia_id;
        $parcialId = $request->parcial_id;

        // Obtener docente del usuario autenticado
        $user = Auth::user();
        $docenteId = $user->docente->id ?? null;

        // Obtener matrículas activas del paralelo
        $matriculas = Matricula::where('paralelo_id', $paraleloId)
            ->where('estado', 'activo')
            ->with(['estudiante.user'])
            ->orderBy('id')
            ->get();

        // Obtener calificaciones existentes para estos estudiantes
        $calificaciones = Calificacion::where('curso_materia_id', $cursoMateriaId)
            ->where('parcial_id', $parcialId)
            ->whereIn('matricula_id', $matriculas->pluck('id'))
            ->with('componentesCalificacion')
            ->get()
            ->keyBy('matricula_id');

        // Preparar datos de estudiantes con calificaciones
        $estudiantes = $matriculas->map(function ($matricula) use ($calificaciones, $cursoMateriaId, $parcialId, $docenteId) {
            $calificacion = $calificaciones->get($matricula->id);

            return [
                'matricula_id' => $matricula->id,
                'estudiante_nombre' => $matricula->estudiante->user->name,
                'calificacion_id' => $calificacion ? $calificacion->id : null,
                'nota_final' => $calificacion ? $calificacion->nota_final : null,
                'estado' => $calificacion ? $calificacion->estado : 'pendiente',
                'observaciones' => $calificacion ? $calificacion->observaciones : null,
                'puede_editar' => $calificacion ? ($calificacion->estado != 'publicada') : true,
                'componentes' => $calificacion ? $calificacion->componentesCalificacion : [],
            ];
        });

        return response()->json($estudiantes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CalificacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $calificacion = Calificacion::create($request->validated());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Calificación registrada exitosamente',
                'calificacion' => $calificacion
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la calificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CalificacionRequest $request, Calificacion $calificacion)
    {
        try {
            // Verificar que no esté publicada (solo admins pueden editar publicadas)
            if ($calificacion->estado == 'publicada' && !Auth::user()->hasRole('administrador')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden editar calificaciones publicadas'
                ], 403);
            }

            DB::beginTransaction();

            $calificacion->update($request->validated());

            // Actualizar estado si no está publicada
            if ($calificacion->estado != 'publicada') {
                $calificacion->update(['estado' => 'modificada']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Calificación actualizada exitosamente',
                'calificacion' => $calificacion
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la calificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calificacion $calificacion)
    {
        try {
            // Verificar que no esté publicada
            if ($calificacion->estado == 'publicada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden eliminar calificaciones publicadas'
                ], 403);
            }

            DB::beginTransaction();

            // Eliminar componentes asociados
            $calificacion->componentesCalificacion()->delete();

            // Eliminar calificación
            $calificacion->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Calificación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la calificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Publicar calificaciones
     */
    public function publicar(Request $request)
    {
        try {
            $calificacionesIds = $request->calificaciones_ids;

            DB::beginTransaction();

            Calificacion::whereIn('id', $calificacionesIds)
                ->update(['estado' => 'publicada']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Calificaciones publicadas exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al publicar las calificaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar estadísticas
     */
    public function estadisticas(Request $request)
    {
        $cursoMateriaId = $request->curso_materia_id;
        $parcialId = $request->parcial_id;

        // Obtener calificaciones
        $calificaciones = Calificacion::where('curso_materia_id', $cursoMateriaId)
            ->where('parcial_id', $parcialId)
            ->whereNotNull('nota_final')
            ->with(['matricula.estudiante.user'])
            ->get();

        // Calcular estadísticas
        $total = $calificaciones->count();
        $promedio = $total > 0 ? $calificaciones->avg('nota_final') : 0;
        $aprobados = $calificaciones->where('nota_final', '>=', 7)->count();
        $enRiesgo = $calificaciones->whereBetween('nota_final', [5, 6.99])->count();
        $reprobados = $calificaciones->where('nota_final', '<', 5)->count();

        // Estudiantes en riesgo (detalle)
        $estudiantesRiesgo = $calificaciones->filter(function ($cal) {
            return $cal->nota_final < 7;
        })->map(function ($cal) {
            return [
                'estudiante' => $cal->matricula->estudiante->user->name,
                'nota' => $cal->nota_final,
                'estado' => $cal->nota_final >= 5 ? 'En Riesgo' : 'Reprobado'
            ];
        })->values();

        return response()->json([
            'total' => $total,
            'promedio' => round($promedio, 2),
            'aprobados' => $aprobados,
            'enRiesgo' => $enRiesgo,
            'reprobados' => $reprobados,
            'estudiantesRiesgo' => $estudiantesRiesgo
        ]);
    }
}
