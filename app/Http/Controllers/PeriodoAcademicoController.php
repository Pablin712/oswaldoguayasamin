<?php

namespace App\Http\Controllers;

use App\Models\PeriodoAcademico;
use App\Http\Requests\PeriodoAcademicoRequest;
use Illuminate\Support\Facades\Gate;

class PeriodoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver periodos académicos') || Gate::denies('gestionar periodos académicos')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver los periodos académicos.');
        }

        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('estructura.periodos-academicos.index', compact('periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeriodoAcademicoRequest $request)
    {
        if (Gate::denies('crear periodos académicos') || Gate::denies('gestionar periodos académicos')) {
            return redirect()->back()->with('error', 'No tienes permiso para crear periodos académicos.');
        }

        PeriodoAcademico::create($request->validated());

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Periodo académico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodoAcademico $periodoAcademico)
    {
        if (Gate::denies('ver periodos académicos') || Gate::denies('gestionar periodos académicos')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver los periodos académicos.');
        }

        return view('estructura.periodos-academicos.show', compact('periodoAcademico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeriodoAcademicoRequest $request, PeriodoAcademico $periodoAcademico)
    {
        if (Gate::denies('editar periodos académicos') || Gate::denies('gestionar periodos académicos')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar periodos académicos.');
        }

        $periodoAcademico->update($request->validated());

        return redirect()->route('periodos-academicos.index')
            ->with('success', 'Periodo académico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeriodoAcademico $periodoAcademico)
    {
        if (Gate::denies('eliminar periodos académicos') || Gate::denies('gestionar periodos académicos')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar periodos académicos.');
        }

        try {
            $periodoAcademico->delete();

            return redirect()->route('periodos-academicos.index')
                ->with('success', 'Periodo académico eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('periodos-academicos.index')
                ->with('error', 'No se puede eliminar el periodo académico porque tiene registros relacionados.');
        }
    }
}
