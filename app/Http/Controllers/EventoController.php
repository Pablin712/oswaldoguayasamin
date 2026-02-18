<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoCurso;
use App\Models\EventoConfirmacion;
use App\Models\PeriodoAcademico;
use App\Models\Paralelo;
use App\Models\Estudiante;
use App\Http\Requests\EventoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evento::with(['periodoAcademico', 'paralelos.curso']);

        // Filtros
        if ($request->filled('periodo_academico_id')) {
            $query->where('periodo_academico_id', $request->periodo_academico_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            switch ($request->estado) {
                case 'proximos':
                    $query->where('fecha_inicio', '>=', now());
                    break;
                case 'pasados':
                    $query->where('fecha_fin', '<', now());
                    break;
                case 'en_curso':
                    $query->where('fecha_inicio', '<=', now())
                          ->where(function ($q) {
                              $q->whereNull('fecha_fin')
                                ->orWhere('fecha_fin', '>=', now());
                          });
                    break;
            }
        }

        // Si no es administrador, solo eventos públicos o de sus paralelos
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasRole('administrador')) {
            $query->where(function ($q) use ($user) {
                $q->where('es_publico', true);

                if ($user->estudiante) {
                    $paralelosIds = $user->estudiante->matriculas()
                        ->where('estado', 'activa')
                        ->pluck('paralelo_id');
                    $q->orWhereHas('paralelos', function ($q2) use ($paralelosIds) {
                        $q2->whereIn('paralelos.id', $paralelosIds);
                    });
                }

                if ($user->docente) {
                    $q->orWhereHas('paralelos.docenteMaterias', function ($q2) use ($user) {
                        $q2->where('docente_id', $user->docente->id);
                    });
                }
            });
        }

        $eventos = $query->orderBy('fecha_inicio', 'desc')
            ->paginate(20);

        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('academico.eventos.index', compact('eventos', 'periodos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periodos = PeriodoAcademico::where('estado', 'activo')
            ->orWhere('estado', 'proximo')
            ->orderBy('fecha_inicio', 'desc')
            ->get();
        $paralelos = Paralelo::with('curso')->get();

        return view('academico.eventos.create', compact('periodos', 'paralelos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventoRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Extraer paralelos para no guardarlos en campos del evento
            $paralelosIds = $data['paralelos'] ?? [];
            unset($data['paralelos']);

            $evento = Evento::create($data);

            // Asociar paralelos si se especificaron
            if (!empty($paralelosIds)) {
                $evento->paralelos()->attach($paralelosIds);
            }

            DB::commit();

            return redirect()
                ->route('eventos.index')
                ->with('success', 'Evento creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear el evento: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load(['periodoAcademico', 'paralelos.curso', 'confirmaciones.user', 'confirmaciones.estudiante.user']);

        // Calcular estadísticas de confirmación
        $estadisticas = [
            'total' => $evento->confirmaciones->count(),
            'confirmados' => $evento->confirmaciones->where('confirmado', true)->count(),
            'no_confirmados' => $evento->confirmaciones->where('confirmado', false)->count(),
            'pendientes' => 0, // Se puede calcular comparando con total de invitados
        ];

        if ($evento->confirmaciones->count() > 0) {
            $estadisticas['porcentaje_confirmados'] = round(
                ($estadisticas['confirmados'] / $estadisticas['total']) * 100,
                2
            );
        } else {
            $estadisticas['porcentaje_confirmados'] = 0;
        }

        return view('academico.eventos.show', compact('evento', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();
        $paralelos = Paralelo::with('curso')->get();
        $evento->load('paralelos');

        return view('academico.eventos.edit', compact('evento', 'periodos', 'paralelos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventoRequest $request, Evento $evento)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Extraer paralelos
            $paralelosIds = $data['paralelos'] ?? [];
            unset($data['paralelos']);

            $evento->update($data);

            // Sincronizar paralelos
            $evento->paralelos()->sync($paralelosIds);

            DB::commit();

            return redirect()
                ->route('eventos.show', $evento)
                ->with('success', 'Evento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el evento: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        try {
            $evento->delete();

            return redirect()
                ->route('eventos.index')
                ->with('success', 'Evento eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el evento: ' . $e->getMessage());
        }
    }

    /**
     * Confirmar asistencia a un evento
     */
    public function confirmar(Request $request, Evento $evento)
    {
        $request->validate([
            'confirmado' => 'required|boolean',
            'estudiante_id' => 'nullable|exists:estudiantes,id',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        try {
            EventoConfirmacion::updateOrCreate(
                [
                    'evento_id' => $evento->id,
                    'user_id' => $user->id,
                    'estudiante_id' => $request->estudiante_id,
                ],
                [
                    'confirmado' => $request->confirmado,
                    'fecha_confirmacion' => now(),
                    'observaciones' => $request->observaciones,
                ]
            );

            $mensaje = $request->confirmado ? 'Asistencia confirmada.' : 'Se ha registrado que no asistirá.';

            return back()->with('success', $mensaje);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al confirmar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Obtener eventos del calendario
     */
    public function calendario(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $query = Evento::query();

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->where(function ($q) use ($request) {
                $q->whereNull('fecha_fin')
                  ->orWhere('fecha_fin', '<=', $request->fecha_fin);
            });
        }

        // Filtrar según permisos del usuario
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasRole('administrador')) {
            $query->where('es_publico', true);
        }

        $eventos = $query->get()->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio . ($evento->hora_inicio ? ' ' . $evento->hora_inicio : ''),
                'end' => ($evento->fecha_fin ?? $evento->fecha_inicio) . ($evento->hora_fin ? ' ' . $evento->hora_fin : ''),
                'tipo' => $evento->tipo,
                'backgroundColor' => $this->getColorByTipo($evento->tipo),
                'url' => route('eventos.show', $evento),
            ];
        });

        return response()->json($eventos);
    }

    /**
     * Obtener color según tipo de evento
     */
    private function getColorByTipo($tipo)
    {
        $colores = [
            'examen' => '#dc2626',      // rojo
            'reunion' => '#2563eb',     // azul
            'actividad' => '#16a34a',   // verde
            'feriado' => '#9333ea',     // morado
            'ceremonia' => '#d97706',   // naranja
            'otro' => '#6b7280',        // gris
        ];

        return $colores[$tipo] ?? '#6b7280';
    }

    /**
     * Ver calendario
     */
    public function verCalendario()
    {
        return view('academico.eventos.calendario');
    }
}
