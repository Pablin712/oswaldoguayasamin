<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\QuimestreController;
use App\Http\Controllers\ParcialController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PadreController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\CursoMateriaController;
use App\Http\Controllers\DocenteMateriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'password.changed'])->name('dashboard');

Route::middleware(['auth', 'password.changed'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);

    // Rutas para permisos (solo index y show)
    Route::get('permissions', [RoleController::class, 'indexPermissions'])->name('permissions.index');
    Route::get('permissions/{permission}', [RoleController::class, 'showPermission'])->name('permissions.show');

    // Fase 2: Instituciones
    Route::get('instituciones', [InstitucionController::class, 'show'])->name('instituciones.show');
    Route::get('instituciones/edit', [InstitucionController::class, 'edit'])->name('instituciones.edit');
    Route::put('instituciones', [InstitucionController::class, 'update'])->name('instituciones.update');

    // Fase 2: Configuraciones
    Route::get('configuraciones', [ConfiguracionController::class, 'index'])->name('configuraciones.index');
    Route::put('configuraciones', [ConfiguracionController::class, 'update'])->name('configuraciones.update');
    Route::post('configuraciones/test-email', [ConfiguracionController::class, 'testEmail'])->name('configuraciones.test-email');

    // Fase 3: Estructura Académica
    Route::resource('periodos-academicos', PeriodoAcademicoController::class)->except(['create', 'edit']);
    Route::resource('quimestres', QuimestreController::class)->except(['create', 'edit']);
    Route::resource('parciales', ParcialController::class)->except(['create', 'edit']);
    Route::resource('cursos', CursoController::class)->except(['create', 'edit']);
    Route::resource('materias', MateriaController::class)->except(['create', 'edit']);
    Route::resource('aulas', AulaController::class)->except(['create', 'edit']);
    Route::resource('areas', AreaController::class)->except(['create', 'edit']);

    // Fase 4: Usuarios Especializados
    Route::resource('docentes', DocenteController::class)->except(['create', 'edit']);
    Route::resource('estudiantes', EstudianteController::class)->except(['create', 'edit']);
    Route::resource('padres', PadreController::class)->except(['create', 'edit']);

    // Relaciones Estudiante-Padre
    Route::post('estudiantes/{estudiante}/padres', [EstudianteController::class, 'attachPadre'])->name('estudiantes.attach-padre');
    Route::delete('estudiantes/{estudiante}/padres/{padre}', [EstudianteController::class, 'detachPadre'])->name('estudiantes.detach-padre');
    Route::put('estudiantes/{estudiante}/padres/{padre}', [EstudianteController::class, 'updatePadreRelation'])->name('estudiantes.update-padre');

    Route::post('padres/{padre}/estudiantes', [PadreController::class, 'attachEstudiante'])->name('padres.attach-estudiante');
    Route::delete('padres/{padre}/estudiantes/{estudiante}', [PadreController::class, 'detachEstudiante'])->name('padres.detach-estudiante');
    Route::put('padres/{padre}/estudiantes/{estudiante}', [PadreController::class, 'updateEstudianteRelation'])->name('padres.update-estudiante');

    // Fase 5: Asignaciones Académicas
    Route::resource('paralelos', ParaleloController::class)->except(['create', 'edit']);
    Route::resource('asignaciones/curso-materia', CursoMateriaController::class)
        ->except(['create', 'edit', 'show'])
        ->names([
            'index' => 'curso-materia.index',
            'store' => 'curso-materia.store',
            'update' => 'curso-materia.update',
            'destroy' => 'curso-materia.destroy',
        ]);

    // Docente-Materia con Horarios
    Route::resource('docente-materia', DocenteMateriaController::class)->except(['create', 'edit', 'show', 'update']);
    Route::get('docente-materia/disponibilidad', [DocenteMateriaController::class, 'disponibilidad'])->name('docente-materia.disponibilidad');
    Route::get('docente-materia/horarios-ocupados', [DocenteMateriaController::class, 'horariosOcupados'])->name('docente-materia.horarios-ocupados');
});

require __DIR__.'/auth.php';
