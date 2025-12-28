<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Materia;
use App\Http\Requests\MateriaRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver materias') && Gate::denies('gestionar materias')) {
            abort(403, 'No tienes permiso para ver materias.');
        }

        $materias = Materia::with('area')
            ->orderBy('area_id')
            ->orderBy('nombre')
            ->get();

        $areas = Area::activas()->orderBy('nombre')->get();

        return view('estructura.materias.index', compact('materias', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MateriaRequest $request)
    {
        if (Gate::denies('crear materias') && Gate::denies('gestionar materias')) {
            abort(403, 'No tienes permiso para crear materias.');
        }

        Materia::create($request->validated());

        return redirect()->route('materias.index')
            ->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materia $materia)
    {
        if (Gate::denies('ver materias') && Gate::denies('gestionar materias')) {
            abort(403, 'No tienes permiso para ver materias.');
        }

        return response()->json($materia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriaRequest $request, Materia $materia)
    {
        if (Gate::denies('editar materias') && Gate::denies('gestionar materias')) {
            abort(403, 'No tienes permiso para editar materias.');
        }

        $materia->update($request->validated());

        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        if (Gate::denies('eliminar materias') && Gate::denies('gestionar materias')) {
            abort(403, 'No tienes permiso para eliminar materias.');
        }

        try {
            $materia->delete();
            return redirect()->route('materias.index')
                ->with('success', 'Materia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('materias.index')
                ->with('error', 'No se puede eliminar la materia porque tiene registros asociados.');
        }
    }
}
