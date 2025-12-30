<?php

namespace App\Policies;

use App\Models\DocenteMateria;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocenteMateriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ver asignaciones docentes') || $user->can('gestionar asignaciones docentes');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DocenteMateria $docenteMateria): bool
    {
        return $user->can('ver asignaciones docentes') || $user->can('gestionar asignaciones docentes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('crear asignaciones docentes') || $user->can('gestionar asignaciones docentes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DocenteMateria $docenteMateria): bool
    {
        return $user->can('editar asignaciones docentes') || $user->can('gestionar asignaciones docentes');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DocenteMateria $docenteMateria): bool
    {
        return $user->can('eliminar asignaciones docentes') || $user->can('gestionar asignaciones docentes');
    }
}
