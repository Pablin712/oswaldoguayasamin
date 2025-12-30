<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteRequest;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver estudiantes') || Gate::denies('gestionar estudiantes')) {
            abort(403, 'No tienes permiso para ver estudiantes.');
        }

        $estudiantes = Estudiante::with('user')
            ->latest()
            ->get();

        return view('usuarios.estudiantes.index', compact('estudiantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstudianteRequest $request)
    {
        if (Gate::denies('crear estudiantes') && Gate::denies('gestionar estudiantes')) {
            abort(403, 'No tienes permiso para crear estudiantes.');
        }

        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'institucion_id' => Auth::user()->institucion_id,
                'name' => $request->nombre_completo,
                'email' => $request->email,
                'password' => Hash::make($request->cedula),
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'estado' => 'activo',
            ]);

            // Asignar rol de estudiante
            $user->assignRole('estudiante');

            // Generar código de estudiante automático
            $ultimoEstudiante = Estudiante::latest('id')->first();
            $numeroConsecutivo = $ultimoEstudiante ? ((int) substr($ultimoEstudiante->codigo_estudiante, 4)) + 1 : 1;
            $codigoEstudiante = 'EST-' . str_pad($numeroConsecutivo, 4, '0', STR_PAD_LEFT);

            // Crear estudiante
            Estudiante::create([
                'user_id' => $user->id,
                'codigo_estudiante' => $codigoEstudiante,
                'fecha_ingreso' => $request->fecha_ingreso,
                'tipo_sangre' => $request->tipo_sangre,
                'alergias' => $request->alergias,
                'contacto_emergencia' => $request->contacto_emergencia,
                'telefono_emergencia' => $request->telefono_emergencia,
                'estado' => $request->estado ?? 'activo',
            ]);

            DB::commit();

            return redirect()->route('estudiantes.index')
                ->with('success', 'Estudiante creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estudiantes.index')
                ->with('error', 'Error al crear el estudiante: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        if (Gate::denies('ver estudiantes') && Gate::denies('gestionar estudiantes')) {
            abort(403, 'No tienes permiso para ver estudiantes.');
        }

        $estudiante->load(['user', 'padres', 'asistencias', 'tareaEstudiantes']);

        return view('usuarios.estudiantes.show', compact('estudiante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstudianteRequest $request, Estudiante $estudiante)
    {
        if (Gate::denies('editar estudiantes') && Gate::denies('gestionar estudiantes')) {
            abort(403, 'No tienes permiso para editar estudiantes.');
        }

        try {
            DB::beginTransaction();

            // Actualizar usuario
            $estudiante->user->update([
                'name' => $request->nombre_completo,
                'email' => $request->email,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);

            // Actualizar estudiante
            $estudiante->update([
                'fecha_ingreso' => $request->fecha_ingreso,
                'tipo_sangre' => $request->tipo_sangre,
                'alergias' => $request->alergias,
                'contacto_emergencia' => $request->contacto_emergencia,
                'telefono_emergencia' => $request->telefono_emergencia,
                'estado' => $request->estado,
            ]);

            DB::commit();

            return redirect()->route('estudiantes.index')
                ->with('success', 'Estudiante actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estudiantes.index')
                ->with('error', 'Error al actualizar el estudiante: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        if (Gate::denies('eliminar estudiantes') && Gate::denies('gestionar estudiantes')) {
            abort(403, 'No tienes permiso para eliminar estudiantes.');
        }

        try {
            DB::beginTransaction();

            // Eliminar usuario (cascade eliminará estudiante)
            $estudiante->user->delete();

            DB::commit();

            return redirect()->route('estudiantes.index')
                ->with('success', 'Estudiante eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estudiantes.index')
                ->with('error', 'No se puede eliminar el estudiante porque tiene registros asociados.');
        }
    }

    /**
     * Attach a padre to an estudiante
     */
    public function attachPadre(Estudiante $estudiante)
    {
        $request = request();
        $request->validate([
            'padre_id' => 'required|exists:padres,id',
            'parentesco' => 'required|in:padre,madre,tutor,otro',
            'es_principal' => 'boolean',
        ]);

        // Verificar que no esté ya relacionado
        if ($estudiante->padres()->where('padre_id', $request->padre_id)->exists()) {
            return back()->with('error', 'Este padre/representante ya está asociado al estudiante.');
        }

        $estudiante->padres()->attach($request->padre_id, [
            'parentesco' => $request->parentesco,
            'es_principal' => $request->es_principal ?? false,
        ]);

        return back()->with('success', 'Padre/Representante asociado exitosamente.');
    }

    /**
     * Detach a padre from an estudiante
     */
    public function detachPadre(Estudiante $estudiante, $padreId)
    {
        $estudiante->padres()->detach($padreId);
        return back()->with('success', 'Padre/Representante desvinculado exitosamente.');
    }

    /**
     * Update pivot data for estudiante-padre relationship
     */
    public function updatePadreRelation(Estudiante $estudiante, $padreId)
    {
        $request = request();
        $request->validate([
            'parentesco' => 'required|in:padre,madre,tutor,otro',
            'es_principal' => 'boolean',
        ]);

        $estudiante->padres()->updateExistingPivot($padreId, [
            'parentesco' => $request->parentesco,
            'es_principal' => $request->es_principal ?? false,
        ]);

        return back()->with('success', 'Relación actualizada exitosamente.');
    }
}
