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
use App\Http\Controllers\ConfiguracionMatriculaController;
use App\Http\Controllers\SolicitudMatriculaController;
use App\Http\Controllers\OrdenPagoController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ComponenteCalificacionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta pública para solicitud de matrícula (estudiantes externos)
Route::get('/solicitar-matricula', [SolicitudMatriculaController::class, 'create'])->name('solicitudes-matricula.create');
Route::post('/solicitar-matricula', [SolicitudMatriculaController::class, 'store'])->name('solicitudes-matricula.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'password.changed'])->name('dashboard');

Route::middleware(['auth', 'password.changed'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para solicitud de matrícula (estudiantes autenticados)
    Route::get('/mis-solicitudes/crear', [SolicitudMatriculaController::class, 'createAuthenticated'])->name('solicitudes-matricula.create-authenticated');

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

    // Fase 5: Sistema de Matrículas
    // Configuración de Matrículas (Vista propia institución)
    Route::get('configuracion/matricula', [ConfiguracionMatriculaController::class, 'show'])->name('configuracion.matricula.show');
    Route::get('configuracion/matricula/editar', [ConfiguracionMatriculaController::class, 'edit'])->name('configuracion.matricula.edit');
    Route::put('configuracion/matricula', [ConfiguracionMatriculaController::class, 'update'])->name('configuracion.matricula.update');

    // Solicitudes de Matrícula
    Route::resource('solicitudes-matricula', SolicitudMatriculaController::class)->except(['edit', 'update']);
    Route::post('solicitudes-matricula/{solicitudMatricula}/aprobar', [SolicitudMatriculaController::class, 'aprobar'])->name('solicitudes-matricula.aprobar');
    Route::post('solicitudes-matricula/{solicitudMatricula}/rechazar', [SolicitudMatriculaController::class, 'rechazar'])->name('solicitudes-matricula.rechazar');
    Route::get('solicitudes-matricula/{solicitudMatricula}/download/{tipo}', [SolicitudMatriculaController::class, 'downloadFile'])->name('solicitudes-matricula.download');

    // Órdenes de Pago
    Route::resource('ordenes-pago', OrdenPagoController::class)->except(['create', 'edit', 'update']);
    Route::post('ordenes-pago/{ordenPago}/upload-comprobante', [OrdenPagoController::class, 'uploadComprobante'])->name('ordenes-pago.upload-comprobante');
    Route::post('ordenes-pago/{ordenPago}/aprobar', [OrdenPagoController::class, 'aprobar'])->name('ordenes-pago.aprobar');
    Route::post('ordenes-pago/{ordenPago}/rechazar', [OrdenPagoController::class, 'rechazar'])->name('ordenes-pago.rechazar');
    Route::get('ordenes-pago/{ordenPago}/download-comprobante', [OrdenPagoController::class, 'downloadComprobante'])->name('ordenes-pago.download-comprobante');

    // Fase 6: Sistema de Calificaciones
    Route::get('calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index')->middleware('can:ver calificaciones');
    Route::get('calificaciones/contexto', [CalificacionController::class, 'cargarContexto'])->name('calificaciones.contexto')->middleware('can:ver calificaciones');
    Route::get('calificaciones/estudiantes', [CalificacionController::class, 'cargarEstudiantes'])->name('calificaciones.estudiantes')->middleware('can:ver calificaciones');
    Route::get('calificaciones/estadisticas', [CalificacionController::class, 'estadisticas'])->name('calificaciones.estadisticas')->middleware('can:ver calificaciones');
    Route::post('calificaciones', [CalificacionController::class, 'store'])->name('calificaciones.store')->middleware('can:registrar calificaciones');
    Route::put('calificaciones/{calificacion}', [CalificacionController::class, 'update'])->name('calificaciones.update')->middleware('can:editar calificaciones');
    Route::delete('calificaciones/{calificacion}', [CalificacionController::class, 'destroy'])->name('calificaciones.destroy')->middleware('can:eliminar calificaciones');
    Route::post('calificaciones/publicar', [CalificacionController::class, 'publicar'])->name('calificaciones.publicar')->middleware('can:publicar calificaciones');

    // Componentes de Calificación
    Route::get('componentes-calificacion', [ComponenteCalificacionController::class, 'index'])->name('componentes.index')->middleware('can:ver componentes');
    Route::post('componentes-calificacion', [ComponenteCalificacionController::class, 'store'])->name('componentes.store')->middleware('can:crear componentes');
    Route::put('componentes-calificacion/{componente}', [ComponenteCalificacionController::class, 'update'])->name('componentes.update')->middleware('can:editar componentes');
    Route::delete('componentes-calificacion/{componente}', [ComponenteCalificacionController::class, 'destroy'])->name('componentes.destroy')->middleware('can:eliminar componentes');

    // Fase 8: Asistencias
    Route::resource('asistencias', \App\Http\Controllers\AsistenciaController::class)->middleware('can:ver asistencias');
    Route::post('asistencias/registro-masivo', [\App\Http\Controllers\AsistenciaController::class, 'registroMasivo'])->name('asistencias.registro-masivo')->middleware('can:registrar asistencia masiva');
    Route::get('asistencias/estadisticas', [\App\Http\Controllers\AsistenciaController::class, 'estadisticas'])->name('asistencias.estadisticas')->middleware('can:ver asistencias');
    Route::get('asistencias/estudiantes', [\App\Http\Controllers\AsistenciaController::class, 'cargarEstudiantes'])->name('asistencias.cargar-estudiantes')->middleware('can:ver asistencias');

    // Fase 8: Justificaciones
    Route::resource('justificaciones', \App\Http\Controllers\JustificacionController::class)->middleware('can:ver justificaciones');
    Route::post('justificaciones/{justificacion}/aprobar', [\App\Http\Controllers\JustificacionController::class, 'aprobar'])->name('justificaciones.aprobar')->middleware('can:aprobar justificaciones');
    Route::post('justificaciones/{justificacion}/rechazar', [\App\Http\Controllers\JustificacionController::class, 'rechazar'])->name('justificaciones.rechazar')->middleware('can:rechazar justificaciones');
    Route::get('justificaciones/pendientes', [\App\Http\Controllers\JustificacionController::class, 'pendientes'])->name('justificaciones.pendientes')->middleware('can:aprobar justificaciones');

    // Fase 9: Tareas
    Route::resource('tareas', \App\Http\Controllers\TareaController::class)->middleware('can:ver tareas');
    Route::delete('tareas/archivos/{archivo}', [\App\Http\Controllers\TareaController::class, 'eliminarArchivo'])->name('tareas.eliminar-archivo')->middleware('can:editar tareas');
    Route::post('tareas/{tareaEstudiante}/calificar', [\App\Http\Controllers\TareaController::class, 'calificar'])->name('tareas.calificar')->middleware('can:calificar tareas');
    Route::post('tareas/{tarea}/completar', [\App\Http\Controllers\TareaController::class, 'completar'])->name('tareas.completar');
    Route::get('tareas/proximas-vencer', [\App\Http\Controllers\TareaController::class, 'proximasVencer'])->name('tareas.proximas-vencer')->middleware('can:ver tareas');

    // Fase 10: Mensajes
    Route::resource('mensajes', \App\Http\Controllers\MensajeController::class)->middleware('can:ver mensajes');
    Route::post('mensajes/{mensaje}/marcar-leido', [\App\Http\Controllers\MensajeController::class, 'marcarLeido'])->name('mensajes.marcar-leido');
    Route::post('mensajes/{mensaje}/marcar-no-leido', [\App\Http\Controllers\MensajeController::class, 'marcarNoLeido'])->name('mensajes.marcar-no-leido');
    Route::get('mensajes/conteo-no-leidos', [\App\Http\Controllers\MensajeController::class, 'conteoNoLeidos'])->name('mensajes.conteo-no-leidos');

    // Fase 10: Notificaciones
    Route::resource('notificaciones', \App\Http\Controllers\NotificacionController::class)->middleware('can:ver notificaciones');
    Route::post('notificaciones/{notificacion}/marcar-leida', [\App\Http\Controllers\NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcar-leida');
    Route::post('notificaciones/{notificacion}/marcar-no-leida', [\App\Http\Controllers\NotificacionController::class, 'marcarNoLeida'])->name('notificaciones.marcar-no-leida');
    Route::post('notificaciones/marcar-todas-leidas', [\App\Http\Controllers\NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar-todas-leidas');
    Route::delete('notificaciones/eliminar-leidas', [\App\Http\Controllers\NotificacionController::class, 'eliminarLeidas'])->name('notificaciones.eliminar-leidas');
    Route::get('notificaciones/conteo-no-leidas', [\App\Http\Controllers\NotificacionController::class, 'conteoNoLeidas'])->name('notificaciones.conteo-no-leidas');
    Route::get('notificaciones/recientes', [\App\Http\Controllers\NotificacionController::class, 'recientes'])->name('notificaciones.recientes');

    // Fase 11: Eventos
    Route::resource('eventos', \App\Http\Controllers\EventoController::class)->middleware('can:ver eventos');
    Route::post('eventos/{evento}/confirmar', [\App\Http\Controllers\EventoController::class, 'confirmar'])->name('eventos.confirmar')->middleware('can:confirmar asistencia eventos');
    Route::get('eventos/calendario/datos', [\App\Http\Controllers\EventoController::class, 'calendario'])->name('eventos.calendario.datos')->middleware('can:ver calendario eventos');
    Route::get('eventos/calendario/vista', [\App\Http\Controllers\EventoController::class, 'verCalendario'])->name('eventos.calendario')->middleware('can:ver calendario eventos');

    // Fase 12: Horarios
    Route::resource('horarios', \App\Http\Controllers\HorarioController::class)->middleware('can:ver horarios');
    Route::get('horarios/paralelo/{paralelo}', [\App\Http\Controllers\HorarioController::class, 'verParalelo'])->name('horarios.paralelo')->middleware('can:ver horario paralelo');
    Route::get('horarios/docente/{docente}', [\App\Http\Controllers\HorarioController::class, 'verDocente'])->name('horarios.docente')->middleware('can:ver horario docente');
    Route::get('horarios/aula/{aula}', [\App\Http\Controllers\HorarioController::class, 'verAula'])->name('horarios.aula')->middleware('can:ver horario aula');

    // Fase 13: Auditoría
    Route::get('auditoria', [\App\Http\Controllers\AuditoriaAccesoController::class, 'index'])->name('auditoria.index')->middleware('can:ver auditoria');
    Route::get('auditoria/{auditoria}', [\App\Http\Controllers\AuditoriaAccesoController::class, 'show'])->name('auditoria.show')->middleware('can:ver auditoria');
    Route::get('auditoria/historial/registro', [\App\Http\Controllers\AuditoriaAccesoController::class, 'historialRegistro'])->name('auditoria.historial-registro')->middleware('can:ver historial registro');
    Route::get('auditoria/usuario/{usuario}', [\App\Http\Controllers\AuditoriaAccesoController::class, 'actividadUsuario'])->name('auditoria.usuario')->middleware('can:ver actividad usuario');
    Route::get('auditoria/estadisticas', [\App\Http\Controllers\AuditoriaAccesoController::class, 'estadisticas'])->name('auditoria.estadisticas')->middleware('can:ver estadisticas auditoria');
    Route::delete('auditoria/limpiar', [\App\Http\Controllers\AuditoriaAccesoController::class, 'limpiar'])->name('auditoria.limpiar')->middleware('can:limpiar auditoria');
    Route::post('auditoria/exportar', [\App\Http\Controllers\AuditoriaAccesoController::class, 'exportar'])->name('auditoria.exportar')->middleware('can:exportar auditoria');
    Route::get('auditoria/reciente', [\App\Http\Controllers\AuditoriaAccesoController::class, 'reciente'])->name('auditoria.reciente')->middleware('can:ver auditoria');
});

require __DIR__.'/auth.php';
