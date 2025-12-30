<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoMateriaRequest;
use App\Models\Curso;
use App\Models\CursoMateria;
use App\Models\Materia;
use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CursoMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::denies('ver asignaciones') || Gate::denies('gestionar asignaciones')) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección.');
        }

        // Obtener filtros
        $cursoId = $request->get('curso_id');
        $periodoId = $request->get('periodo_id');

        // Si no hay período seleccionado, usar el actual de configuración
        if (!$periodoId) {
            $periodoId = config('app.periodo_actual_id'); // O desde configuraciones
        }

        // Obtener todos los cursos y períodos para los filtros
        $cursos = Curso::orderBy('orden')->get();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        // Obtener las asignaciones del curso seleccionado
        $asignaciones = collect();
        $cursoSeleccionado = null;
        $totalHoras = 0;

        if ($cursoId && $periodoId) {
            $cursoSeleccionado = Curso::find($cursoId);
            $asignaciones = CursoMateria::where('curso_id', $cursoId)
                ->where('periodo_academico_id', $periodoId)
                ->with(['materia'])
                ->orderBy('materia_id')
                ->get();

            $totalHoras = $asignaciones->sum('horas_semanales');
        }

        return view('academico.asignaciones.curso-materia.index', compact(
            'cursos',
            'periodos',
            'cursoId',
            'periodoId',
            'asignaciones',
            'cursoSeleccionado',
            'totalHoras'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoMateriaRequest $request)
    {
        if (Gate::denies('crear asignaciones') || Gate::denies('gestionar asignaciones')) {
            return redirect()->back()->with('error', 'No tiene permisos para crear asignaciones.');
        }

        CursoMateria::create($request->validated());

        return redirect()->back()->with('success', 'Materia asignada exitosamente al curso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoMateriaRequest $request, CursoMateria $cursoMateria)
    {
        if (Gate::denies('editar asignaciones') || Gate::denies('gestionar asignaciones')) {
            return redirect()->back()->with('error', 'No tiene permisos para editar asignaciones.');
        }

        $cursoMateria->update($request->validated());

        return redirect()->back()->with('success', 'Horas de materia actualizadas exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CursoMateria $cursoMateria)
    {
        if (Gate::denies('eliminar asignaciones') || Gate::denies('gestionar asignaciones')) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar asignaciones.');
        }

        $materia = $cursoMateria->materia->nombre;
        $cursoMateria->delete();

        return redirect()->back()->with('success', "La materia '{$materia}' ha sido removida del curso.");
    }
}
