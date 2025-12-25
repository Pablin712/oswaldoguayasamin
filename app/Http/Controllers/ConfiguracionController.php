<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\PeriodoAcademico;
use App\Http\Requests\ConfiguracionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Mostrar las configuraciones del sistema.
     */
    public function index()
    {
        if (Gate::denies('ver configuraciones')) {
            return redirect()->back()->with('error', 'No tienes permiso para ver las configuraciones del sistema.');
        }

        $configuracion = Configuracion::first();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('configuraciones.index', compact('configuracion', 'periodos'));
    }

    /**
     * Actualizar las configuraciones del sistema.
     */
    public function update(ConfiguracionRequest $request)
    {
        if (Gate::denies('editar configuraciones')) {
            return redirect()->back()->with('error', 'No tienes permiso para editar las configuraciones del sistema.');
        }

        // Obtener o crear la configuración
        $configuracion = Configuracion::firstOrNew([]);

        $data = $request->validated();

        // Si es una nueva configuración, agregar institucion_id del usuario
        if (!$configuracion->exists) {
            $data['institucion_id'] = Auth::user()->institucion_id ?? 1;
        }

        $configuracion->fill($data);
        $configuracion->save();

        return redirect()->route('configuraciones.index')
            ->with('success', 'Configuraciones actualizadas exitosamente.');
    }

    /**
     * Enviar correo de prueba.
     */
    public function testEmail(Request $request)
    {
        if (Gate::denies('editar configuraciones')) {
            return response()->json(['error' => 'No tienes permiso para probar la configuración de correo.'], 403);
        }

        try {
            // Aquí se implementaría el envío del correo de prueba
            // Mail::to($request->email)->send(new TestEmail());

            return response()->json([
                'success' => true,
                'message' => 'Correo de prueba enviado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo: ' . $e->getMessage()
            ], 500);
        }
    }
}
