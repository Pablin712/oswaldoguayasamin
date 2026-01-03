<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionMatricula;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ConfiguracionMatriculaController extends Controller
{
    /**
     * Display the configuration for the authenticated user's institution.
     */
    public function show()
    {
        if (Gate::denies('ver configuracion matriculas') && Gate::denies('gestionar configuracion matriculas')) {
            abort(403, 'No tienes permiso para ver la configuración de matrículas.');
        }

        // Obtener la institución del usuario autenticado
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $institucion = $user->institucion;

        if (!$institucion) {
            abort(404, 'No tienes una institución asignada.');
        }

        // Buscar o crear la configuración de matrícula para esta institución
        /** @var \App\Models\ConfiguracionMatricula $configuracion */
        $configuracion = ConfiguracionMatricula::firstOrCreate(
            ['institucion_id' => $institucion->id],
            [
                'tipo_institucion' => $institucion->tipo ?? 'fiscal',
                'monto_primera_matricula' => 0.00,
                'monto_segunda_matricula' => 0.00,
            ]
        );

        $configuracion->load('institucion');

        return view('academico.matriculas.configuracion.show', compact('configuracion', 'institucion'));
    }

    /**
     * Show the form for editing the configuration.
     */
    public function edit()
    {
        if (Gate::denies('editar configuracion matriculas') && Gate::denies('gestionar configuracion matriculas')) {
            abort(403, 'No tienes permiso para editar la configuración de matrículas.');
        }

        $user = Auth::user();
        $institucion = $user->institucion;

        if (!$institucion) {
            abort(404, 'No tienes una institución asignada.');
        }

        /** @var \App\Models\ConfiguracionMatricula $configuracion */
        $configuracion = ConfiguracionMatricula::firstOrCreate(
            ['institucion_id' => $institucion->id],
            [
                'tipo_institucion' => $institucion->tipo ?? 'fiscal',
                'monto_primera_matricula' => 0.00,
                'monto_segunda_matricula' => 0.00,
            ]
        );

        $configuracion->load('institucion');

        return view('academico.matriculas.configuracion.edit', compact('configuracion', 'institucion'));
    }

    /**
     * Update the configuration in storage.
     */
    public function update(Request $request)
    {
        if (Gate::denies('editar configuracion matriculas') && Gate::denies('gestionar configuracion matriculas')) {
            abort(403, 'No tienes permiso para editar configuraciones de matrícula.');
        }

        $user = Auth::user();
        $institucion = $user->institucion;

        if (!$institucion) {
            abort(404, 'No tienes una institución asignada.');
        }

        $configuracion = ConfiguracionMatricula::where('institucion_id', $institucion->id)->firstOrFail();

        $validated = $request->validate([
            'tipo_institucion' => ['required', Rule::in(['fiscal', 'fiscomisional', 'particular'])],
            'monto_primera_matricula' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'monto_segunda_matricula' => ['required', 'numeric', 'min:0', 'max:9999.99'],
        ]);

        $configuracion->update($validated);

        return redirect()->route('configuracion.matricula.show')
            ->with('success', 'Configuración de matrícula actualizada exitosamente.');
    }
}
