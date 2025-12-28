<?php

namespace App\Http\Controllers;

use App\Models\Quimestre;
use App\Models\PeriodoAcademico;
use App\Http\Requests\QuimestreRequest;
use Illuminate\Support\Facades\Gate;

class QuimestreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver quimestres') && Gate::denies('gestionar quimestres')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver los quimestres.');
        }

        $quimestres = Quimestre::with('periodoAcademico')->orderBy('fecha_inicio', 'desc')->get();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('quimestres.index', compact('quimestres', 'periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuimestreRequest $request)
    {
        if (Gate::denies('crear quimestres') && Gate::denies('gestionar quimestres')) {
            return redirect()->back()->with('error', 'No tienes permiso para crear quimestres.');
        }

        Quimestre::create($request->validated());

        return redirect()->route('quimestres.index')
            ->with('success', 'Quimestre creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quimestre $quimestre)
    {
        if (Gate::denies('ver quimestres') && Gate::denies('gestionar quimestres')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver los quimestres.');
        }

        $quimestre->load('periodoAcademico', 'parciales');

        return view('quimestres.show', compact('quimestre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuimestreRequest $request, Quimestre $quimestre)
    {
        if (Gate::denies('editar quimestres') && Gate::denies('gestionar quimestres')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar quimestres.');
        }

        $quimestre->update($request->validated());

        return redirect()->route('quimestres.index')
            ->with('success', 'Quimestre actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quimestre $quimestre)
    {
        if (Gate::denies('eliminar quimestres') && Gate::denies('gestionar quimestres')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar quimestres.');
        }

        try {
            $quimestre->delete();

            return redirect()->route('quimestres.index')
                ->with('success', 'Quimestre eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('quimestres.index')
                ->with('error', 'No se puede eliminar el quimestre porque tiene registros relacionados.');
        }
    }
}
