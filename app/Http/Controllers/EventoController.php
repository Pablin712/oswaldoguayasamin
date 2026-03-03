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
use Illuminate\Support\Facades\Log;

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
        $periodoActivo = PeriodoAcademico::where('estado', 'activo')->first();
        $paralelos = Paralelo::with('curso')->get();

        return view('academico.eventos.index', compact('eventos', 'periodos', 'periodoActivo', 'paralelos'));
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
        // Si es una petición AJAX, devolver JSON
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            try {
                $evento->load('paralelos');
                return response()->json([
                    'id' => $evento->id,
                    'titulo' => $evento->titulo,
                    'descripcion' => $evento->descripcion,
                    'tipo' => $evento->tipo,
                    'periodo_academico_id' => $evento->periodo_academico_id,
                    'fecha_inicio' => $evento->fecha_inicio?->format('Y-m-d'),
                    'hora_inicio' => $evento->hora_inicio,
                    'fecha_fin' => $evento->fecha_fin?->format('Y-m-d'),
                    'hora_fin' => $evento->hora_fin,
                    'ubicacion' => $evento->ubicacion,
                    'es_publico' => $evento->es_publico,
                    'requiere_confirmacion' => $evento->requiere_confirmacion,
                    'paralelos' => $evento->paralelos->pluck('id')->toArray(),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error al cargar el evento',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

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

        // Filtrar eventos que intersectan con el rango de fechas de FullCalendar
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Convertir las fechas de FullCalendar a solo fecha (sin hora)
            $fechaInicio = \Carbon\Carbon::parse($request->fecha_inicio)->startOfDay();
            $fechaFin = \Carbon\Carbon::parse($request->fecha_fin)->endOfDay();

            Log::info('Calendario request', [
                'fecha_inicio_request' => $request->fecha_inicio,
                'fecha_fin_request' => $request->fecha_fin,
                'fecha_inicio_parsed' => $fechaInicio->toDateString(),
                'fecha_fin_parsed' => $fechaFin->toDateString(),
            ]);

            $query->where(function ($q) use ($fechaInicio, $fechaFin) {
                // Eventos que empiezan antes del fin del rango y terminan después del inicio del rango
                $q->where('fecha_inicio', '<=', $fechaFin->toDateString())
                  ->where(function ($q2) use ($fechaInicio) {
                      $q2->where('fecha_fin', '>=', $fechaInicio->toDateString())
                         ->orWhereNull('fecha_fin');
                  });
            });
        }

        // Filtrar según permisos del usuario
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

        $eventos = $query->get()->map(function ($evento) {
            // Formatear fecha de inicio
            $fechaInicio = $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d') : null;
            $start = $fechaInicio;
            if ($evento->hora_inicio) {
                $start .= 'T' . substr($evento->hora_inicio, 0, 8); // Asegurar formato HH:MM:SS
            }

            // Formatear fecha fin
            $fechaFin = $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d') : $fechaInicio;
            $end = $fechaFin;
            if ($evento->hora_fin) {
                $end .= 'T' . substr($evento->hora_fin, 0, 8);
            } elseif ($evento->hora_inicio) {
                // Si no hay hora_fin pero hay hora_inicio, usar hora_inicio + 1 hora
                $end .= 'T' . substr($evento->hora_inicio, 0, 8);
            }

            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $start,
                'end' => $end,
                'tipo' => $evento->tipo,
                'backgroundColor' => $this->getColorByTipo($evento->tipo),
                'borderColor' => $this->getColorByTipo($evento->tipo),
                'url' => route('eventos.show', $evento),
                'extendedProps' => [
                    'ubicacion' => $evento->ubicacion,
                    'descripcion' => $evento->descripcion,
                ],
            ];
        });

        Log::info('Calendario response', [
            'total_eventos' => $eventos->count(),
            'eventos' => $eventos->take(3), // Solo los primeros 3 para no saturar el log
        ]);

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
