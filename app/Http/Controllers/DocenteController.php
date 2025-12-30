<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocenteRequest;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('ver docentes') || Gate::denies('gestionar docentes')) {
            abort(403, 'No tienes permiso para ver docentes.');
        }

        $docentes = Docente::with('user')
            ->latest()
            ->get();

        return view('usuarios.docentes.index', compact('docentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocenteRequest $request)
    {
        if (Gate::denies('crear docentes') || Gate::denies('gestionar docentes')) {
            abort(403, 'No tienes permiso para crear docentes.');
        }

        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'institucion_id' => Auth::user()->institucion_id,
                'name' => $request->nombre_completo,
                'email' => $request->email,
                'password' => Hash::make($request->cedula), // Password inicial = cédula
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'estado' => 'activo',
            ]);

            // Asignar rol de profesor
            $user->assignRole('profesor');

            // Generar código de docente automático
            $ultimoDocente = Docente::latest('id')->first();
            $numeroConsecutivo = $ultimoDocente ? ((int) substr($ultimoDocente->codigo_docente, 4)) + 1 : 1;
            $codigoDocente = 'DOC-' . str_pad($numeroConsecutivo, 3, '0', STR_PAD_LEFT);

            // Crear docente
            Docente::create([
                'user_id' => $user->id,
                'codigo_docente' => $codigoDocente,
                'titulo_profesional' => $request->titulo_profesional,
                'especialidad' => $request->especialidad,
                'fecha_ingreso' => $request->fecha_ingreso,
                'tipo_contrato' => $request->tipo_contrato,
                'estado' => $request->estado ?? 'activo',
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('docentes.index')
                ->with('error', 'Error al crear el docente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        if (Gate::denies('ver docentes') || Gate::denies('gestionar docentes')) {
            abort(403, 'No tienes permiso para ver docentes.');
        }

        $docente->load(['user', 'asistenciasRegistradas', 'tareas', 'horarios']);

        return view('usuarios.docentes.show', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocenteRequest $request, Docente $docente)
    {
        if (Gate::denies('editar docentes') || Gate::denies('gestionar docentes')) {
            abort(403, 'No tienes permiso para editar docentes.');
        }

        try {
            DB::beginTransaction();

            // Actualizar usuario
            $docente->user->update([
                'name' => $request->nombre_completo,
                'email' => $request->email,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'fecha_nacimiento' => $request->fecha_nacimiento,
            ]);

            // Actualizar docente
            $docente->update([
                'codigo_docente' => $request->codigo_docente,
                'titulo_profesional' => $request->titulo_profesional,
                'especialidad' => $request->especialidad,
                'fecha_ingreso' => $request->fecha_ingreso,
                'tipo_contrato' => $request->tipo_contrato,
                'estado' => $request->estado,
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('docentes.index')
                ->with('error', 'Error al actualizar el docente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        if (Gate::denies('eliminar docentes') || Gate::denies('gestionar docentes')) {
            abort(403, 'No tienes permiso para eliminar docentes.');
        }

        try {
            DB::beginTransaction();

            // Eliminar usuario (cascade eliminará docente)
            $docente->user->delete();

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('docentes.index')
                ->with('error', 'No se puede eliminar el docente porque tiene registros asociados.');
        }
    }
}
