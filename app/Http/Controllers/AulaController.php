<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Http\Requests\AulaRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver aulas') && Gate::denies('gestionar aulas')) {
            abort(403, 'No tienes permiso para ver aulas.');
        }

        $aulas = Aula::orderBy('edificio')
            ->orderBy('piso')
            ->orderBy('nombre')
            ->get();

        return view('estructura.aulas.index', compact('aulas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AulaRequest $request)
    {
        if (Gate::denies('crear aulas') && Gate::denies('gestionar aulas')) {
            abort(403, 'No tienes permiso para crear aulas.');
        }

        Aula::create($request->validated());

        return redirect()->route('aulas.index')
            ->with('success', 'Aula creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        if (Gate::denies('ver aulas') && Gate::denies('gestionar aulas')) {
            abort(403, 'No tienes permiso para ver aulas.');
        }

        return view('estructura.aulas.show', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AulaRequest $request, Aula $aula)
    {
        if (Gate::denies('editar aulas') && Gate::denies('gestionar aulas')) {
            abort(403, 'No tienes permiso para editar aulas.');
        }

        $aula->update($request->validated());

        return redirect()->route('aulas.index')
            ->with('success', 'Aula actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        if (Gate::denies('eliminar aulas') && Gate::denies('gestionar aulas')) {
            abort(403, 'No tienes permiso para eliminar aulas.');
        }

        try {
            $aula->delete();
            return redirect()->route('aulas.index')
                ->with('success', 'Aula eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('aulas.index')
                ->with('error', 'No se puede eliminar el aula porque tiene registros asociados.');
        }
    }
}
