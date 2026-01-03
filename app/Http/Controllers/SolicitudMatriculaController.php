<?php

namespace App\Http\Controllers;

use App\Models\SolicitudMatricula;
use App\Models\Curso;
use App\Models\PeriodoAcademico;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SolicitudMatriculaController extends Controller
{
    /**
     * Display a listing of the resource (Para administradores).
     */
    public function index()
    {
        if (Gate::denies('ver solicitudes matricula') && Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para ver solicitudes de matrícula.');
        }

        // Filtros
        $estado = request('estado', '');
        $cursoId = request('curso_id', '');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $solicitudesQuery = SolicitudMatricula::with([
            'estudiante.user',
            'cursoSolicitado',
            'periodoAcademico.institucion',
            'revisor'
        ]);

        // Filtrar por institución solo si el usuario tiene una asignada
        if ($user->institucion_id) {
            $solicitudesQuery->whereHas('periodoAcademico', function($query) use ($user) {
                $query->where('institucion_id', $user->institucion_id);
            });
        }

        $solicitudesQuery->orderBy('created_at', 'desc');

        if ($estado) {
            $solicitudesQuery->where('estado', $estado);
        }

        if ($cursoId) {
            $solicitudesQuery->where('curso_solicitado_id', $cursoId);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator<\App\Models\SolicitudMatricula> $solicitudesMatricula */
        $solicitudesMatricula = $solicitudesQuery->paginate(20)->withQueryString();

        // Para filtros
        $cursos = Curso::orderBy('orden')
            ->get();

        return view('academico.matriculas.solicitudes.index', [
            'solicitudesMatricula' => $solicitudesMatricula,
            'cursos' => $cursos,
            'estado' => $estado,
            'cursoId' => $cursoId
        ]);
    }

    /**
     * Show the form for creating a new resource (Formulario público).
     */
    public function create()
    {
        // Verificar si hay períodos académicos activos
        $periodosActivos = PeriodoAcademico::where('estado', 'activo')
            ->with('institucion')
            ->get();

        if ($periodosActivos->isEmpty()) {
            return redirect()->route('welcome')
                ->with('info', 'No hay períodos de matrícula disponibles en este momento. Por favor, inténtelo más tarde.');
        }

        $cursos = Curso::where('estado', 'activo')->orderBy('orden')->get();
        $instituciones = \App\Models\Institucion::all();
        $periodos = $periodosActivos;

        return view('academico.matriculas.solicitudes.create', compact('cursos', 'instituciones', 'periodos'));
    }

    /**
     * Show the form for creating a new resource (Formulario para estudiantes autenticados).
     */
    public function createAuthenticated()
    {
        // Verificar si hay períodos académicos activos
        $periodosActivos = PeriodoAcademico::where('estado', 'activo')
            ->with('institucion')
            ->get();

        if ($periodosActivos->isEmpty()) {
            return redirect()->route('dashboard')
                ->with('info', 'No hay períodos de matrícula disponibles en este momento. Por favor, consulte con la administración.');
        }

        $cursos = Curso::where('estado', 'activo')->orderBy('orden')->get();
        $periodos = $periodosActivos;

        return view('academico.matriculas.solicitudes.create-authenticated', compact('cursos', 'periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'cedula' => ['required', 'string', 'size:10', 'unique:solicitudes_matricula,cedula'],
            'email' => ['required', 'email', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'institucion_origen' => ['nullable', 'string', 'max:255'],
            'curso_solicitado_id' => ['required', 'exists:cursos,id'],
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'adjunto_cedula' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'adjunto_certificado' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'observaciones' => ['nullable', 'string'],
        ]);

        // Guardar archivos
        $cedulaPath = $request->file('adjunto_cedula')->store('solicitudes/cedulas', 'private');
        $certificadoPath = $request->file('adjunto_certificado')->store('solicitudes/certificados', 'private');

        $validated['adjunto_cedula_path'] = $cedulaPath;
        $validated['adjunto_certificado_path'] = $certificadoPath;
        $validated['estado'] = 'pendiente';

        SolicitudMatricula::create($validated);

        return redirect()->route('solicitudes-matricula.create')
            ->with('success', 'Solicitud de matrícula enviada exitosamente. Será revisada por el personal administrativo.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Gate::denies('ver solicitudes matricula') && Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para ver esta solicitud.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $solicitudMatricula = SolicitudMatricula::with([
            'estudiante.user',
            'cursoSolicitado',
            'periodoAcademico.institucion',
            'revisor'
        ])->findOrFail($id);

        // Verificar que pertenece a la institución del usuario (si el usuario tiene institución asignada)
        if ($user->institucion_id && $solicitudMatricula->periodoAcademico?->institucion_id !== $user->institucion_id) {
            abort(403, 'No tienes permiso para ver esta solicitud.');
        }

        return view('academico.matriculas.solicitudes.show', compact('solicitudMatricula'));
    }

    /**
     * Aprobar una solicitud de matrícula.
     */
    public function aprobar(Request $request, $id)
    {
        if (Gate::denies('aprobar solicitudes matricula') && Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para aprobar solicitudes de matrícula.');
        }

        $solicitudMatricula = SolicitudMatricula::findOrFail($id);

        if ($solicitudMatricula->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar solicitudes pendientes.');
        }

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        // Crear usuario para el estudiante
        $user = \App\Models\User::create([
            'institucion_id' => $solicitudMatricula->periodoAcademico->institucion_id,
            'name' => $solicitudMatricula->nombres . ' ' . $solicitudMatricula->apellidos,
            'cedula' => $solicitudMatricula->cedula,
            'email' => $solicitudMatricula->email,
            'password' => \Illuminate\Support\Facades\Hash::make($solicitudMatricula->cedula),
            'telefono' => $solicitudMatricula->telefono,
            'estado' => 'activo',
        ]);

        // Asignar rol de estudiante
        $user->assignRole('estudiante');

        // Generar código de estudiante
        $ultimoEstudiante = Estudiante::latest('id')->first();
        $numeroConsecutivo = $ultimoEstudiante ? ((int) substr($ultimoEstudiante->codigo_estudiante, 4)) + 1 : 1;
        $codigoEstudiante = 'EST-' . str_pad($numeroConsecutivo, 4, '0', STR_PAD_LEFT);

        // Crear estudiante
        $estudiante = Estudiante::create([
            'user_id' => $user->id,
            'codigo_estudiante' => $codigoEstudiante,
            'fecha_ingreso' => now(),
            'estado' => 'activo',
        ]);

        // Actualizar solicitud
        $solicitudMatricula->update([
            'estudiante_id' => $estudiante->id,
            'estado' => 'aprobada',
            'revisado_por' => $currentUser->id,
            'fecha_revision' => now(),
        ]);

        return redirect()->route('solicitudes-matricula.index')
            ->with('success', 'Solicitud aprobada exitosamente. Estudiante creado con usuario: ' . $user->email);
    }

    /**
     * Rechazar una solicitud de matrícula.
     */
    public function rechazar(Request $request, $id)
    {
        if (Gate::denies('rechazar solicitudes matricula') && Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para rechazar solicitudes de matrícula.');
        }

        $solicitudMatricula = SolicitudMatricula::findOrFail($id);

        if ($solicitudMatricula->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden rechazar solicitudes pendientes.');
        }

        $solicitudMatricula->update([
            'estado' => 'rechazada',
            'revisado_por' => Auth::id(),
            'fecha_revision' => now(),
        ]);

        return redirect()->route('solicitudes-matricula.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Descargar archivo adjunto.
     */
    public function downloadFile($id, $tipo)
    {
        if (Gate::denies('ver solicitudes matricula') && Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para descargar archivos.');
        }

        $solicitudMatricula = SolicitudMatricula::findOrFail($id);

        $path = $tipo === 'cedula'
            ? $solicitudMatricula->adjunto_cedula_path
            : $solicitudMatricula->adjunto_certificado_path;

        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('private')->download($path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SolicitudMatricula $solicitudMatricula)
    {
        if (Gate::denies('gestionar solicitudes matricula')) {
            abort(403, 'No tienes permiso para eliminar solicitudes de matrícula.');
        }

        // Eliminar archivos adjuntos
        if ($solicitudMatricula->adjunto_cedula_path) {
            Storage::disk('private')->delete($solicitudMatricula->adjunto_cedula_path);
        }
        if ($solicitudMatricula->adjunto_certificado_path) {
            Storage::disk('private')->delete($solicitudMatricula->adjunto_certificado_path);
        }

        $solicitudMatricula->delete();

        return redirect()->route('solicitudes-matricula.index')
            ->with('success', 'Solicitud eliminada exitosamente.');
    }
}
