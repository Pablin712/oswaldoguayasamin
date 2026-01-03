<?php

namespace App\Http\Controllers;

use App\Models\OrdenPago;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class OrdenPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver ordenes pago') && Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para ver órdenes de pago.');
        }

        // Filtros
        $estado = request('estado', '');
        $tipoPago = request('tipo_pago', '');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ordenesQuery = OrdenPago::with([
            'matricula.estudiante.user',
            'matricula.paralelo.curso',
            'matricula.periodoAcademico.institucion',
            'revisor'
        ]);

        // Filtrar por institución solo si el usuario tiene una asignada
        if ($user->institucion_id) {
            $ordenesQuery->whereHas('matricula.estudiante.user', function($query) use ($user) {
                $query->where('institucion_id', $user->institucion_id);
            });
        }

        $ordenesQuery->orderBy('created_at', 'desc');

        if ($estado) {
            $ordenesQuery->where('estado', $estado);
        }

        if ($tipoPago) {
            $ordenesQuery->where('tipo_pago', $tipoPago);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator<\App\Models\OrdenPago> $ordenesPago */
        $ordenesPago = $ordenesQuery->paginate(20)->withQueryString();

        return view('academico.matriculas.ordenes-pago.index', [
            'ordenesPago' => $ordenesPago,
            'estado' => $estado,
            'tipoPago' => $tipoPago
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para crear órdenes de pago.');
        }

        $validated = $request->validate([
            'matricula_id' => ['required', 'exists:matriculas,id'],
            'monto' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'tipo_pago' => ['required', 'in:primera_matricula,segunda_matricula'],
        ]);

        $validated['estado'] = 'pendiente';

        OrdenPago::create($validated);

        return redirect()->route('ordenes-pago.index')
            ->with('success', 'Orden de pago creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Gate::denies('ver ordenes pago') && Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para ver esta orden de pago.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ordenPago = OrdenPago::with([
            'matricula.estudiante.user',
            'matricula.paralelo.curso',
            'matricula.periodoAcademico.institucion',
            'revisor'
        ])->findOrFail($id);

        // Verificar que pertenece a la institución del usuario (si el usuario tiene institución asignada)
        if ($user->institucion_id && $ordenPago->matricula?->estudiante?->user?->institucion_id !== $user->institucion_id) {
            abort(403, 'No tienes permiso para ver esta orden de pago.');
        }

        return view('academico.matriculas.ordenes-pago.show', compact('ordenPago'));
    }

    /**
     * Subir comprobante de pago.
     */
    public function uploadComprobante(Request $request, $id)
    {
        $validated = $request->validate([
            'comprobante' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $ordenPago = OrdenPago::findOrFail($id);

        if ($ordenPago->estado !== 'pendiente') {
            return back()->with('error', 'Solo se puede subir comprobante a órdenes pendientes.');
        }

        // Eliminar comprobante anterior si existe
        if ($ordenPago->comprobante_path) {
            Storage::disk('private')->delete($ordenPago->comprobante_path);
        }

        // Guardar nuevo comprobante
        $comprobantePath = $request->file('comprobante')->store('comprobantes', 'private');

        $ordenPago->update([
            'comprobante_path' => $comprobantePath,
        ]);

        return back()->with('success', 'Comprobante subido exitosamente. En espera de revisión.');
    }

    /**
     * Aprobar una orden de pago.
     */
    public function aprobar(Request $request, $id)
    {
        if (Gate::denies('aprobar ordenes pago') && Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para aprobar órdenes de pago.');
        }

        $ordenPago = OrdenPago::findOrFail($id);

        if ($ordenPago->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar órdenes pendientes.');
        }

        if (!$ordenPago->comprobante_path && $ordenPago->monto > 0) {
            return back()->with('error', 'No se puede aprobar una orden sin comprobante de pago.');
        }

        $ordenPago->update([
            'estado' => 'aprobada',
            'revisado_por' => Auth::id(),
            'fecha_revision' => now(),
        ]);

        // Si hay matrícula asociada, actualizar su estado
        if ($ordenPago->matricula) {
            $ordenPago->matricula->update([
                'estado' => 'aprobada',
                'fecha_aprobacion' => now(),
                'aprobado_por' => Auth::id(),
            ]);
        }

        return redirect()->route('ordenes-pago.index')
            ->with('success', 'Orden de pago aprobada exitosamente.');
    }

    /**
     * Rechazar una orden de pago.
     */
    public function rechazar(Request $request, $id)
    {
        if (Gate::denies('rechazar ordenes pago') && Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para rechazar órdenes de pago.');
        }

        $ordenPago = OrdenPago::findOrFail($id);

        if ($ordenPago->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden rechazar órdenes pendientes.');
        }

        $ordenPago->update([
            'estado' => 'rechazada',
            'revisado_por' => Auth::id(),
            'fecha_revision' => now(),
        ]);

        // Si hay matrícula asociada, actualizar su estado
        if ($ordenPago->matricula) {
            $ordenPago->matricula->update([
                'estado' => 'rechazada',
            ]);
        }

        return redirect()->route('ordenes-pago.index')
            ->with('success', 'Orden de pago rechazada exitosamente.');
    }

    /**
     * Descargar comprobante de pago.
     */
    public function downloadComprobante($id)
    {
        if (Gate::denies('ver ordenes pago') && Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para descargar comprobantes.');
        }

        $ordenPago = OrdenPago::findOrFail($id);

        if (!$ordenPago->comprobante_path) {
            abort(404, 'No hay comprobante disponible.');
        }

        if (!Storage::disk('private')->exists($ordenPago->comprobante_path)) {
            abort(404, 'Archivo no encontrado.');
        }

        // Comentar el método download para que el ide no marque error
        return Storage::disk('private')->download($ordenPago->comprobante_path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrdenPago $ordenPago)
    {
        if (Gate::denies('gestionar ordenes pago')) {
            abort(403, 'No tienes permiso para eliminar órdenes de pago.');
        }

        // Eliminar comprobante si existe
        if ($ordenPago->comprobante_path) {
            Storage::disk('private')->delete($ordenPago->comprobante_path);
        }

        $ordenPago->delete();

        return redirect()->route('ordenes-pago.index')
            ->with('success', 'Orden de pago eliminada exitosamente.');
    }
}
