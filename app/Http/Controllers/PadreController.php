<?php

namespace App\Http\Controllers;

use App\Http\Requests\PadreRequest;
use App\Models\Padre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class PadreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Permitir solo a usuarios con cualquiera de estos permisos adecuados
        if (Gate::denies('ver padres') || Gate::denies('gestionar padres')) {
            abort(403, 'No tienes permiso para ver padres/representantes.');
        }

        $padres = Padre::with('user', 'estudiantes')
            ->latest()
            ->get();

        return view('usuarios.padres.index', compact('padres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PadreRequest $request)
    {
        if (Gate::denies('crear padres') || Gate::denies('gestionar padres')) {
            abort(403, 'No tienes permiso para crear padres/representantes.');
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

            // Asignar rol de representante
            $user->assignRole('representante');

            // Crear padre/representante
            Padre::create([
                'user_id' => $user->id,
                'ocupacion' => $request->ocupacion,
                'lugar_trabajo' => $request->lugar_trabajo,
                'telefono_trabajo' => $request->telefono_trabajo,
            ]);

            DB::commit();

            return redirect()->route('padres.index')
                ->with('success', 'Padre/Representante creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('padres.index')
                ->with('error', 'Error al crear el padre/representante: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Padre $padre)
    {
        if (Gate::denies('ver padres') && Gate::denies('gestionar padres')) {
            abort(403, 'No tienes permiso para ver padres/representantes.');
        }

        $padre->load(['user', 'estudiantes', 'justificaciones']);

        return view('usuarios.padres.show', compact('padre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PadreRequest $request, Padre $padre)
    {
        if (Gate::denies('editar padres') && Gate::denies('gestionar padres')) {
            abort(403, 'No tienes permiso para editar padres/representantes.');
        }

        try {
            DB::beginTransaction();

            // Actualizar usuario
            $padre->user->update([
                'name' => $request->nombre_completo,
                'email' => $request->email,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);

            // Actualizar padre
            $padre->update([
                'ocupacion' => $request->ocupacion,
                'lugar_trabajo' => $request->lugar_trabajo,
                'telefono_trabajo' => $request->telefono_trabajo,
            ]);

            DB::commit();

            return redirect()->route('padres.index')
                ->with('success', 'Padre/Representante actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('padres.index')
                ->with('error', 'Error al actualizar el padre/representante: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Padre $padre)
    {
        if (Gate::denies('eliminar padres') && Gate::denies('gestionar padres')) {
            abort(403, 'No tienes permiso para eliminar padres/representantes.');
        }

        try {
            DB::beginTransaction();

            // Eliminar usuario (cascade eliminará padre)
            $padre->user->delete();

            DB::commit();

            return redirect()->route('padres.index')
                ->with('success', 'Padre/Representante eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('padres.index')
                ->with('error', 'No se puede eliminar el padre/representante porque tiene registros asociados.');
        }
    }

    /**
     * Attach an estudiante to a padre
     */
    public function attachEstudiante(Padre $padre)
    {
        $request = request();
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'parentesco' => 'required|in:padre,madre,tutor,otro',
            'es_principal' => 'boolean',
        ]);

        // Verificar que no esté ya relacionado
        if ($padre->estudiantes()->where('estudiante_id', $request->estudiante_id)->exists()) {
            return back()->with('error', 'Este estudiante ya está asociado a este padre/representante.');
        }

        $padre->estudiantes()->attach($request->estudiante_id, [
            'parentesco' => $request->parentesco,
            'es_principal' => $request->es_principal ?? false,
        ]);

        return back()->with('success', 'Estudiante asociado exitosamente.');
    }

    /**
     * Detach an estudiante from a padre
     */
    public function detachEstudiante(Padre $padre, $estudianteId)
    {
        $padre->estudiantes()->detach($estudianteId);
        return back()->with('success', 'Estudiante desvinculado exitosamente.');
    }

    /**
     * Update pivot data for padre-estudiante relationship
     */
    public function updateEstudianteRelation(Padre $padre, $estudianteId)
    {
        $request = request();
        $request->validate([
            'parentesco' => 'required|in:padre,madre,tutor,otro',
            'es_principal' => 'boolean',
        ]);

        $padre->estudiantes()->updateExistingPivot($estudianteId, [
            'parentesco' => $request->parentesco,
            'es_principal' => $request->es_principal ?? false,
        ]);

        return back()->with('success', 'Relación actualizada exitosamente.');
    }
}
