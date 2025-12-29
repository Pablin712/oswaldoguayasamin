<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParaleloRequest;
use App\Models\Paralelo;
use App\Models\Curso;
use App\Models\Aula;
use App\Models\PeriodoAcademico;
use Illuminate\Support\Facades\Gate;

class ParaleloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver paralelos') && Gate::denies('gestionar paralelos')) {
            abort(403, 'No tienes permiso para ver paralelos.');
        }

        // Obtener filtros
        $cursoId = request('curso_id');
        $periodoId = request('periodo_id', session('periodo_actual_id'));

        // Obtener cursos con paralelos
        $cursosQuery = Curso::with(['paralelos.aula', 'paralelos.matriculas' => function($query) use ($periodoId) {
            if ($periodoId) {
                $query->whereHas('periodoAcademico', function($q) use ($periodoId) {
                    $q->where('id', $periodoId);
                });
            }
            $query->where('estado', 'activa');
        }])->orderBy('orden');

        if ($cursoId) {
            $cursosQuery->where('id', $cursoId);
        }

        $cursos = $cursosQuery->get();

        // Para los filtros
        $todosLosCursos = Curso::orderBy('orden')->get();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('academico.paralelos.index', compact('cursos', 'todosLosCursos', 'periodos', 'cursoId', 'periodoId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParaleloRequest $request)
    {
        if (Gate::denies('crear paralelos') && Gate::denies('gestionar paralelos')) {
            abort(403, 'No tienes permiso para crear paralelos.');
        }

        Paralelo::create($request->validated());

        return redirect()->route('paralelos.index')
            ->with('success', 'Paralelo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paralelo $paralelo)
    {
        if (Gate::denies('ver paralelos') && Gate::denies('gestionar paralelos')) {
            abort(403, 'No tienes permiso para ver paralelos.');
        }

        $paralelo->load([
            'curso',
            'aula',
            'matriculas.estudiante.user',
            'docenteMaterias.docente.user',
            'docenteMaterias.cursoMateria.materia',
            'horarios.materia',
            'horarios.docente.user'
        ]);

        // Calcular estadísticas
        $totalEstudiantes = $paralelo->matriculas->where('estado', 'activa')->count();
        $porcentajeOcupacion = $paralelo->cupo_maximo > 0
            ? round(($totalEstudiantes / $paralelo->cupo_maximo) * 100, 2)
            : 0;
        $totalDocentes = $paralelo->docenteMaterias->unique('docente_id')->count();

        return view('academico.paralelos.show', compact('paralelo', 'totalEstudiantes', 'porcentajeOcupacion', 'totalDocentes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParaleloRequest $request, Paralelo $paralelo)
    {
        if (Gate::denies('editar paralelos') && Gate::denies('gestionar paralelos')) {
            abort(403, 'No tienes permiso para editar paralelos.');
        }

        $paralelo->update($request->validated());

        return redirect()->route('paralelos.index')
            ->with('success', 'Paralelo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paralelo $paralelo)
    {
        if (Gate::denies('eliminar paralelos') && Gate::denies('gestionar paralelos')) {
            abort(403, 'No tienes permiso para eliminar paralelos.');
        }

        try {
            $paralelo->delete();
            return redirect()->route('paralelos.index')
                ->with('success', 'Paralelo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('paralelos.index')
                ->with('error', 'No se puede eliminar el paralelo porque tiene registros asociados.');
        }
    }
}
