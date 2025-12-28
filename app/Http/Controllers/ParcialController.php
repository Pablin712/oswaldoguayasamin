<?php

namespace App\Http\Controllers;

use App\Models\Parcial;
use App\Models\Quimestre;
use App\Http\Requests\ParcialRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ParcialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver parciales') && Gate::denies('gestionar parciales')) {
            abort(403, 'No tienes permiso para ver parciales.');
        }

        $parciales = Parcial::with('quimestre.periodoAcademico')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        $quimestres = Quimestre::with('periodoAcademico')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('estructura.parciales.index', compact('parciales', 'quimestres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParcialRequest $request)
    {
        if (Gate::denies('crear parciales') && Gate::denies('gestionar parciales')) {
            abort(403, 'No tienes permiso para crear parciales.');
        }

        Parcial::create($request->validated());

        return redirect()->route('parciales.index')
            ->with('success', 'Parcial creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parcial $parcial)
    {
        if (Gate::denies('ver parciales') && Gate::denies('gestionar parciales')) {
            abort(403, 'No tienes permiso para ver parciales.');
        }

        $parcial->load('quimestre.periodoAcademico');

        return response()->json($parcial);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParcialRequest $request, Parcial $parcial)
    {
        if (Gate::denies('editar parciales') && Gate::denies('gestionar parciales')) {
            abort(403, 'No tienes permiso para editar parciales.');
        }

        $parcial->update($request->validated());

        return redirect()->route('parciales.index')
            ->with('success', 'Parcial actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parcial $parcial)
    {
        if (Gate::denies('eliminar parciales') && Gate::denies('gestionar parciales')) {
            abort(403, 'No tienes permiso para eliminar parciales.');
        }

        try {
            $parcial->delete();
            return redirect()->route('parciales.index')
                ->with('success', 'Parcial eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('parciales.index')
                ->with('error', 'No se puede eliminar el parcial porque tiene registros asociados.');
        }
    }
}
