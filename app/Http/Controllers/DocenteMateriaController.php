<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteMateriaRequest;
use App\Models\DocenteMateria;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Paralelo;
use App\Models\PeriodoAcademico;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DocenteMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', DocenteMateria::class);

        $periodoActual = PeriodoAcademico::where('estado', 'activo')->first();

        // Filtros
        $periodoId = $request->get('periodo_id', $periodoActual?->id);
        $cursoId = $request->get('curso_id');
        $paraleloId = $request->get('paralelo_id');

        // Construir query
        $query = Materia::with([
            'docenteMaterias' => function ($query) use ($periodoId, $paraleloId) {
                $query->where('periodo_academico_id', $periodoId)
                    ->when($paraleloId, fn($q) => $q->where('paralelo_id', $paraleloId))
                    ->with([
                        'docente.user',
                        'paralelo.curso',
                        'paralelo.aula',
                        'horarios' => fn($q) => $q->orderBy('dia_semana')->orderBy('hora_inicio')
                    ]);
            },
            'area'
        ])->where('estado', 'activa');

        // Filtrar materias que tienen asignaciones en el período seleccionado
        $query->whereHas('docenteMaterias', function ($q) use ($periodoId, $paraleloId) {
            $q->where('periodo_academico_id', $periodoId)
                ->when($paraleloId, fn($query) => $query->where('paralelo_id', $paraleloId));
        });

        $materias = $query->orderBy('nombre')->get();

        // Datos para filtros
        $periodos = PeriodoAcademico::orderBy('nombre', 'desc')->get();
        $cursos = Curso::orderBy('nombre')->get();

        // Obtener TODOS los paralelos del período para el filtrado dinámico
        $todosParalelosFiltro = Paralelo::where('periodo_academico_id', $periodoId)
            ->with('curso', 'aula')
            ->orderBy('nombre')
            ->get();

        // Paralelos filtrados por curso (para cuando ya hay un curso seleccionado)
        $paralelos = $todosParalelosFiltro->when($cursoId, fn($collection) =>
            $collection->filter(fn($p) => $p->curso_id == $cursoId)
        );

        // Datos para modal de asignación
        $docentes = Docente::with('user')->where('estado', 'activo')->get();
        $todasMaterias = Materia::with('area')->where('estado', 'activa')->orderBy('nombre')->get();

        // Obtener todos los paralelos del período actual para el modal
        $todosParalelos = Paralelo::where('periodo_academico_id', $periodoId)
            ->with('curso', 'aula')
            ->orderBy('nombre')
            ->get();

        return view('academico.asignaciones.docente-materia.index', compact(
            'materias',
            'periodos',
            'cursos',
            'paralelos',
            'todosParalelosFiltro',
            'todosParalelos',
            'docentes',
            'todasMaterias',
            'periodoActual',
            'periodoId',
            'cursoId',
            'paraleloId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocenteMateriaRequest $request)
    {
        Gate::authorize('create', DocenteMateria::class);

        try {
            DB::beginTransaction();

            // Crear asignación
            $docenteMateria = DocenteMateria::create([
                'docente_id' => $request->docente_id,
                'materia_id' => $request->materia_id,
                'paralelo_id' => $request->paralelo_id,
                'periodo_academico_id' => $request->periodo_academico_id,
                'rol' => $request->rol ?? 'Principal',
            ]);

            // Crear horarios
            foreach ($request->horarios as $horario) {
                Horario::create([
                    'docente_materia_id' => $docenteMateria->id,
                    'dia_semana' => $horario['dia_semana'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fin' => $horario['hora_fin'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Asignación creada exitosamente con ' . count($request->horarios) . ' horario(s).',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la asignación: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocenteMateria $docenteMateria)
    {
        Gate::authorize('delete', $docenteMateria);

        try {
            $horarios = $docenteMateria->horarios()->count();
            $docenteMateria->delete(); // Los horarios se eliminan por CASCADE

            return response()->json([
                'success' => true,
                'message' => "Asignación eliminada exitosamente ({$horarios} horario(s) eliminados).",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la asignación: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener disponibilidad del docente
     */
    public function disponibilidad(Request $request)
    {
        $docenteId = $request->get('docente_id');
        $periodoAcademicoId = $request->get('periodo_academico_id');

        if (!$docenteId || !$periodoAcademicoId) {
            return response()->json(['error' => 'Parámetros inválidos'], 400);
        }

        // Obtener todos los horarios del docente en el período
        $horarios = Horario::whereHas('docenteMateria', function ($query) use ($docenteId, $periodoAcademicoId) {
                $query->where('docente_id', $docenteId)
                    ->where('periodo_academico_id', $periodoAcademicoId);
            })
            ->with('docenteMateria.materia', 'docenteMateria.paralelo')
            ->get();

        // Calcular carga horaria total
        $cargaTotal = 0;
        foreach ($horarios as $horario) {
            $inicio = \Carbon\Carbon::parse($horario->hora_inicio);
            $fin = \Carbon\Carbon::parse($horario->hora_fin);
            $cargaTotal += $inicio->diffInMinutes($fin) / 60;
        }

        return response()->json([
            'horarios' => $horarios,
            'carga_total' => round($cargaTotal, 2),
            'disponible' => $cargaTotal < 25, // Máximo 25 horas semanales
        ]);
    }

    /**
     * Obtener horarios ocupados para matriz de disponibilidad
     */
    public function horariosOcupados(Request $request)
    {
        $paraleloId = $request->get('paralelo_id');
        $periodoAcademicoId = $request->get('periodo_academico_id');

        if (!$paraleloId || !$periodoAcademicoId) {
            return response()->json(['error' => 'Parámetros inválidos'], 400);
        }

        // Obtener horarios del paralelo
        $horarios = Horario::whereHas('docenteMateria', function ($query) use ($paraleloId, $periodoAcademicoId) {
                $query->where('paralelo_id', $paraleloId)
                    ->where('periodo_academico_id', $periodoAcademicoId);
            })
            ->with('docenteMateria.materia', 'docenteMateria.docente.user')
            ->get();

        return response()->json(['horarios' => $horarios]);
    }
}
