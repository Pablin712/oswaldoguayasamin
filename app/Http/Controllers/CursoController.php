<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Http\Requests\CursoRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver cursos') || Gate::denies('gestionar cursos')) {
            abort(403, 'No tienes permiso para ver cursos.');
        }

        $cursos = Curso::orderBy('nivel')
            ->orderBy('orden')
            ->get();

        return view('estructura.cursos.index', compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        if (Gate::denies('crear cursos') || Gate::denies('gestionar cursos')) {
            abort(403, 'No tienes permiso para crear cursos.');
        }

        Curso::create($request->validated());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        if (Gate::denies('ver cursos') || Gate::denies('gestionar cursos')) {
            abort(403, 'No tienes permiso para ver cursos.');
        }

        $curso->loadCount('materias');

        return view('estructura.cursos.show', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CursoRequest $request, Curso $curso)
    {
        if (Gate::denies('editar cursos') || Gate::denies('gestionar cursos')) {
            abort(403, 'No tienes permiso para editar cursos.');
        }

        $curso->update($request->validated());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        if (Gate::denies('eliminar cursos') || Gate::denies('gestionar cursos')) {
            abort(403, 'No tienes permiso para eliminar cursos.');
        }

        try {
            $curso->delete();
            return redirect()->route('cursos.index')
                ->with('success', 'Curso eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('cursos.index')
                ->with('error', 'No se puede eliminar el curso porque tiene registros asociados.');
        }
    }
}
