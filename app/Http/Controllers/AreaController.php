<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\AreaRequest;
use Illuminate\Support\Facades\Gate;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver areas') && Gate::denies('gestionar areas')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver las áreas.');
        }

        $areas = Area::withCount('materias')->orderBy('nombre')->get();

        return view('estructura.areas.index', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        if (Gate::denies('crear areas') && Gate::denies('gestionar areas')) {
            return redirect()->back()->with('error', 'No tienes permiso para crear áreas.');
        }

        Area::create($request->validated());

        return redirect()->route('areas.index')
            ->with('success', 'Área creada exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area)
    {
        if (Gate::denies('editar areas') && Gate::denies('gestionar areas')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar áreas.');
        }

        $area->update($request->validated());

        return redirect()->route('areas.index')
            ->with('success', 'Área actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        if (Gate::denies('eliminar areas') && Gate::denies('gestionar areas')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar áreas.');
        }

        // Verificar si tiene materias asociadas
        if ($area->materias()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el área porque tiene materias asociadas.');
        }

        $area->delete();

        return redirect()->route('areas.index')
            ->with('success', 'Área eliminada exitosamente.');
    }
}
