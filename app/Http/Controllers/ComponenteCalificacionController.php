<?php

namespace App\Http\Controllers;

use App\Models\ComponenteCalificacion;
use App\Models\Calificacion;
use App\Http\Requests\ComponenteCalificacionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponenteCalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $calificacionId = $request->calificacion_id;

        $componentes = ComponenteCalificacion::where('calificacion_id', $calificacionId)
            ->orderBy('tipo')
            ->orderBy('created_at')
            ->get();

        return response()->json($componentes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComponenteCalificacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $componente = ComponenteCalificacion::create($request->validated());

            // Recalcular nota final de la calificación
            $this->recalcularNotaFinal($componente->calificacion_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Componente registrado exitosamente',
                'componente' => $componente
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el componente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComponenteCalificacionRequest $request, ComponenteCalificacion $componente)
    {
        try {
            // Verificar que la calificación no esté publicada
            if ($componente->calificacion->estado == 'publicada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden editar componentes de calificaciones publicadas'
                ], 403);
            }

            DB::beginTransaction();

            $componente->update($request->validated());

            // Recalcular nota final de la calificación
            $this->recalcularNotaFinal($componente->calificacion_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Componente actualizado exitosamente',
                'componente' => $componente
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el componente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponenteCalificacion $componente)
    {
        try {
            // Verificar que la calificación no esté publicada
            if ($componente->calificacion->estado == 'publicada') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden eliminar componentes de calificaciones publicadas'
                ], 403);
            }

            DB::beginTransaction();

            $calificacionId = $componente->calificacion_id;

            $componente->delete();

            // Recalcular nota final de la calificación
            $this->recalcularNotaFinal($calificacionId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Componente eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el componente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recalcular nota final basada en componentes
     */
    private function recalcularNotaFinal($calificacionId)
    {
        $calificacion = Calificacion::findOrFail($calificacionId);

        // Obtener componentes agrupados por tipo
        $componentes = ComponenteCalificacion::where('calificacion_id', $calificacionId)
            ->get()
            ->groupBy('tipo');

        $notaFinal = 0;

        // Calcular promedio por tipo y aplicar porcentaje
        foreach ($componentes as $tipo => $items) {
            $promedioTipo = $items->avg('nota');
            $porcentajeTipo = $items->first()->porcentaje;
            $notaFinal += ($promedioTipo * $porcentajeTipo / 100);
        }

        // Actualizar nota final
        $calificacion->update([
            'nota_final' => round($notaFinal, 2),
            'estado' => $calificacion->estado == 'publicada' ? 'publicada' : 'modificada'
        ]);
    }
}
