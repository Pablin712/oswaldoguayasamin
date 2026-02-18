<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaAcceso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditoriaAccesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AuditoriaAcceso::with('user');

        // Filtros
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('tabla_afectada')) {
            $query->where('tabla_afectada', $request->tabla_afectada);
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        $auditorias = $query->orderBy('created_at', 'desc')
            ->paginate(50);

        $usuarios = User::orderBy('name')->get();

        // Obtener tablas únicas para filtro
        $tablas = AuditoriaAcceso::select('tabla_afectada')
            ->distinct()
            ->whereNotNull('tabla_afectada')
            ->orderBy('tabla_afectada')
            ->pluck('tabla_afectada');

        return view('sistema.auditoria.index', compact('auditorias', 'usuarios', 'tablas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditoriaAcceso $auditoria)
    {
        $auditoria->load('user');

        return view('sistema.auditoria.show', compact('auditoria'));
    }

    /**
     * Ver historial de un registro específico
     */
    public function historialRegistro(Request $request)
    {
        $request->validate([
            'tabla' => 'required|string',
            'registro_id' => 'required|integer',
        ]);

        $historial = AuditoriaAcceso::where('tabla_afectada', $request->tabla)
            ->where('registro_id', $request->registro_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sistema.auditoria.historial', compact('historial'));
    }

    /**
     * Ver actividad de un usuario
     */
    public function actividadUsuario($userId)
    {
        $usuario = User::findOrFail($userId);

        $actividades = AuditoriaAcceso::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Estadísticas
        $estadisticas = [
            'total_acciones' => AuditoriaAcceso::where('user_id', $userId)->count(),
            'logins' => AuditoriaAcceso::where('user_id', $userId)->where('accion', 'login')->count(),
            'creates' => AuditoriaAcceso::where('user_id', $userId)->where('accion', 'create')->count(),
            'updates' => AuditoriaAcceso::where('user_id', $userId)->where('accion', 'update')->count(),
            'deletes' => AuditoriaAcceso::where('user_id', $userId)->where('accion', 'delete')->count(),
            'ultimo_acceso' => AuditoriaAcceso::where('user_id', $userId)
                ->where('accion', 'login')
                ->orderBy('created_at', 'desc')
                ->first()?->created_at,
        ];

        return view('sistema.auditoria.usuario', compact('usuario', 'actividades', 'estadisticas'));
    }

    /**
     * Obtener estadísticas generales
     */
    public function estadisticas(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $query = AuditoriaAcceso::query();

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        $estadisticas = [
            'total_acciones' => $query->count(),
            'por_accion' => (clone $query)->select('accion', DB::raw('count(*) as total'))
                ->groupBy('accion')
                ->pluck('total', 'accion'),
            'por_tabla' => (clone $query)->select('tabla_afectada', DB::raw('count(*) as total'))
                ->whereNotNull('tabla_afectada')
                ->groupBy('tabla_afectada')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->pluck('total', 'tabla_afectada'),
            'usuarios_activos' => (clone $query)->distinct('user_id')->count('user_id'),
            'ips_unicas' => (clone $query)->distinct('ip_address')->count('ip_address'),
        ];

        return view('sistema.auditoria.estadisticas', compact('estadisticas'));
    }

    /**
     * Eliminar registros antiguos de auditoría
     */
    public function limpiar(Request $request)
    {
        $request->validate([
            'dias' => 'required|integer|min:30|max:365',
        ]);

        $fecha = now()->subDays($request->dias);

        $eliminados = AuditoriaAcceso::where('created_at', '<', $fecha)->delete();

        return redirect()
            ->route('auditoria.index')
            ->with('success', "Se eliminaron {$eliminados} registros de auditoría anteriores a " . $fecha->format('d/m/Y'));
    }

    /**
     * Exportar auditoría
     */
    public function exportar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'formato' => 'required|in:csv,excel,pdf',
        ]);

        // Aquí implementarías la lógica de exportación
        // Por ejemplo usando Laravel Excel o similar

        return back()->with('info', 'La exportación de auditoría está en desarrollo.');
    }

    /**
     * Ver actividad reciente (dashboard)
     */
    public function reciente()
    {
        $actividades = AuditoriaAcceso::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json($actividades);
    }
}
