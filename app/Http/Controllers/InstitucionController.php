<?php

namespace App\Http\Controllers;

use App\Models\Institucion;
use App\Http\Requests\InstitucionRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class InstitucionController extends Controller
{
    /**
     * Mostrar la información de la institución.
     */
    public function show()
    {
        if (Gate::denies('ver institución')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver la información de la institución.');
        }

        $institucion = Institucion::first();

        return view('instituciones.show', compact('institucion'));
    }

    /**
     * Mostrar el formulario para editar la institución.
     */
    public function edit()
    {
        if (Gate::denies('editar institución')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar la institución.');
        }

        $institucion = Institucion::first();

        return view('instituciones.edit', compact('institucion'));
    }

    /**
     * Actualizar la información de la institución.
     */
    public function update(InstitucionRequest $request)
    {
        if (Gate::denies('editar institución')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar la institución.');
        }

        $institucion = Institucion::first();

        $data = $request->validated();

        // Manejar la carga del logo
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($institucion->logo && Storage::disk('public')->exists($institucion->logo)) {
                Storage::disk('public')->delete($institucion->logo);
            }

            // Guardar el nuevo logo
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $institucion->update($data);

        return redirect()->route('instituciones.show')
            ->with('success', 'Información de la institución actualizada exitosamente.');
    }
}
