<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\DocenteMateria;
use App\Models\Aula;
use App\Models\PeriodoAcademico;
use App\Http\Requests\HorarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Horario::with(['docenteMateria.paralelo.curso', 'docenteMateria.materia', 'docenteMateria.docente.user', 'docenteMateria.periodoAcademico', 'paralelo', 'materia', 'docente']);

        // Filtros
        if ($request->filled('paralelo_id')) {
            $query->delParalelo($request->paralelo_id);
        }

        if ($request->filled('docente_id')) {
            $query->delDocente($request->docente_id);
        }

        if ($request->filled('aula_id')) {
            $query->delAula($request->aula_id);
        }

        if ($request->filled('dia_semana')) {
            $query->where('dia_semana', $request->dia_semana);
        }

        if ($request->filled('periodo_academico_id')) {
            $query->delPeriodo($request->periodo_academico_id);
        }

        // Si es docente, solo sus horarios
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->docente && !$user->hasRole('administrador')) {
            $query->delDocente($user->docente->id);
        }

        $horarios = $query->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->paginate(50);

        $paralelos = Paralelo::with('curso')->get();
        $docentes = Docente::with('user')->get();
        $aulas = Aula::all();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('academico.horarios.index', compact('horarios', 'paralelos', 'docentes', 'aulas', 'periodos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paralelos = Paralelo::with('curso')->get();
        $materias = Materia::all();
        $docentes = Docente::with('user')->get();
        $aulas = Aula::all();
        $periodos = PeriodoAcademico::where('estado', 'activo')
            ->orWhere('estado', 'proximo')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('academico.horarios.create', compact('paralelos', 'materias', 'docentes', 'aulas', 'periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HorarioRequest $request)
    {
        try {
            DB::beginTransaction();

            // Buscar o crear DocenteMateria
            $docenteMateria = DocenteMateria::firstOrCreate([
                'docente_id' => $request->docente_id,
                'materia_id' => $request->materia_id,
                'paralelo_id' => $request->paralelo_id,
                'periodo_academico_id' => $request->periodo_academico_id,
            ]);

            // Verificar conflictos
            $conflicto = $this->verificarConflictos(
                $request->paralelo_id,
                $request->docente_id,
                $request->aula_id,
                $request->dia_semana,
                $request->hora_inicio,
                $request->hora_fin,
                $request->periodo_academico_id
            );

            if ($conflicto) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->with('error', $conflicto);
            }

            // Crear horario con solo los campos que existen en la tabla
            Horario::create([
                'docente_materia_id' => $docenteMateria->id,
                'dia_semana' => $request->dia_semana,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
            ]);

            DB::commit();

            return redirect()
                ->route('horarios.index')
                ->with('success', 'Horario creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al crear el horario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        $horario->load(['docenteMateria.paralelo.curso', 'docenteMateria.materia', 'docenteMateria.docente.user', 'docenteMateria.periodoAcademico', 'paralelo', 'materia', 'docente']);

        return view('academico.horarios.show', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        $paralelos = Paralelo::with('curso')->get();
        $materias = Materia::all();
        $docentes = Docente::with('user')->get();
        $aulas = Aula::all();
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();

        return view('academico.horarios.edit', compact('horario', 'paralelos', 'materias', 'docentes', 'aulas', 'periodos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HorarioRequest $request, Horario $horario)
    {
        try {
            DB::beginTransaction();

            // Buscar o crear DocenteMateria
            $docenteMateria = DocenteMateria::firstOrCreate([
                'docente_id' => $request->docente_id,
                'materia_id' => $request->materia_id,
                'paralelo_id' => $request->paralelo_id,
                'periodo_academico_id' => $request->periodo_academico_id,
            ]);

            // Verificar conflictos excluyendo el horario actual
            $conflicto = $this->verificarConflictos(
                $request->paralelo_id,
                $request->docente_id,
                $request->aula_id,
                $request->dia_semana,
                $request->hora_inicio,
                $request->hora_fin,
                $request->periodo_academico_id,
                $horario->id
            );

            if ($conflicto) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->with('error', $conflicto);
            }

            // Actualizar solo los campos que existen en la tabla
            $horario->update([
                'docente_materia_id' => $docenteMateria->id,
                'dia_semana' => $request->dia_semana,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
            ]);

            DB::commit();

            return redirect()
                ->route('horarios.show', $horario)
                ->with('success', 'Horario actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el horario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        try {
            $horario->delete();

            return redirect()
                ->route('horarios.index')
                ->with('success', 'Horario eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el horario: ' . $e->getMessage());
        }
    }

    /**
     * Ver horario de un paralelo
     */
    public function verParalelo($paraleloId)
    {
        $paralelo = Paralelo::with('curso')->findOrFail($paraleloId);

        $horarios = Horario::delParalelo($paraleloId)
            ->with(['materia', 'docente', 'paralelo'])
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('dia_semana');

        return view('academico.horarios.paralelo', compact('paralelo', 'horarios'));
    }

    /**
     * Ver horario de un docente
     */
    public function verDocente($docenteId)
    {
        $docente = Docente::with('user')->findOrFail($docenteId);

        $horarios = Horario::delDocente($docenteId)
            ->with(['paralelo.curso', 'materia', 'docente'])
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('dia_semana');

        return view('academico.horarios.docente', compact('docente', 'horarios'));
    }

    /**
     * Ver horario de un aula
     */
    public function verAula($aulaId)
    {
        $aula = Aula::findOrFail($aulaId);

        $horarios = Horario::delAula($aulaId)
            ->with(['paralelo.curso', 'materia', 'docente'])
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('dia_semana');

        return view('academico.horarios.aula', compact('aula', 'horarios'));
    }

    /**
     * Verificar conflictos de horario
     */
    private function verificarConflictos($paraleloId, $docenteId, $aulaId, $diaSemana, $horaInicio, $horaFin, $periodoId, $excluirId = null)
    {
        // Verificar conflicto de paralelo
        $conflictoParalelo = Horario::delParalelo($paraleloId)
            ->where('dia_semana', $diaSemana)
            ->delPeriodo($periodoId)
            ->when($excluirId, function ($q) use ($excluirId) {
                $q->where('id', '!=', $excluirId);
            })
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                  ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                  ->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                      $q2->where('hora_inicio', '<=', $horaInicio)
                         ->where('hora_fin', '>=', $horaFin);
                  });
            })
            ->exists();

        if ($conflictoParalelo) {
            return 'El paralelo ya tiene una clase programada en este horario.';
        }

        // Verificar conflicto de docente
        $conflictoDocente = Horario::delDocente($docenteId)
            ->where('dia_semana', $diaSemana)
            ->delPeriodo($periodoId)
            ->when($excluirId, function ($q) use ($excluirId) {
                $q->where('id', '!=', $excluirId);
            })
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                  ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                  ->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                      $q2->where('hora_inicio', '<=', $horaInicio)
                         ->where('hora_fin', '>=', $horaFin);
                  });
            })
            ->exists();

        if ($conflictoDocente) {
            return 'El docente ya tiene una clase programada en este horario.';
        }

        // Verificar conflicto de aula (si se especificó)
        if ($aulaId) {
            $conflictoAula = Horario::delAula($aulaId)
                ->where('dia_semana', $diaSemana)
                ->delPeriodo($periodoId)
                ->when($excluirId, function ($q) use ($excluirId) {
                    $q->where('id', '!=', $excluirId);
                })
                ->where(function ($q) use ($horaInicio, $horaFin) {
                    $q->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                      ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                      ->orWhere(function ($q2) use ($horaInicio, $horaFin) {
                          $q2->where('hora_inicio', '<=', $horaInicio)
                             ->where('hora_fin', '>=', $horaFin);
                      });
                })
                ->exists();

            if ($conflictoAula) {
                return 'El aula ya está ocupada en este horario.';
            }
        }

        return null;
    }
}
