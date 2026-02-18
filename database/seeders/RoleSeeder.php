<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aquí puedes definir los roles que deseas crear
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $estudianteRole = Role::firstOrCreate(['name' => 'estudiante']);
        $profesorRole = Role::firstOrCreate(['name' => 'profesor']);
        $representanteRole = Role::firstOrCreate(['name' => 'representante']);

        // Crear permisos
        $permissions = [
            'ver dashboard',
            'generar reportes',

            'gestionar usuarios',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'generar reporte usuarios',

            'gestionar roles y permisos',
            'ver roles y permisos',
            'crear roles',
            'editar roles',
            'eliminar roles',
            'generar reporte roles y permisos',

            // Fase 2: Instituciones
            'gestionar institución',
            'ver institución',
            'editar institución',

            // Fase 2: Configuraciones
            'gestionar configuraciones',
            'ver configuraciones',
            'editar configuraciones',

            // Fase 3: Periodos Académicos
            'gestionar periodos académicos',
            'ver periodos académicos',
            'crear periodos académicos',
            'editar periodos académicos',
            'eliminar periodos académicos',
            'generar reporte periodos académicos',

            // Fase 3: Quimestres
            'gestionar quimestres',
            'ver quimestres',
            'crear quimestres',
            'editar quimestres',
            'eliminar quimestres',
            'generar reporte quimestres',

            // Fase 3: Parciales
            'gestionar parciales',
            'ver parciales',
            'crear parciales',
            'editar parciales',
            'eliminar parciales',
            'generar reporte parciales',

            // Fase 3: Cursos
            'gestionar cursos',
            'ver cursos',
            'crear cursos',
            'editar cursos',
            'eliminar cursos',
            'generar reporte cursos',

            // Fase 3: Materias
            'gestionar materias',
            'ver materias',
            'crear materias',
            'editar materias',
            'eliminar materias',
            'generar reporte materias',

            // Fase 3: Áreas
            'gestionar areas',
            'ver areas',
            'crear areas',
            'editar areas',
            'eliminar areas',
            'generar reporte areas',

            // Fase 3: Aulas
            'gestionar aulas',
            'ver aulas',
            'crear aulas',
            'editar aulas',
            'eliminar aulas',
            'generar reporte aulas',

            // Fase 4: Docentes
            'gestionar docentes',
            'ver docentes',
            'crear docentes',
            'editar docentes',
            'eliminar docentes',
            'generar reporte docentes',

            // Fase 4: Estudiantes
            'gestionar estudiantes',
            'ver estudiantes',
            'crear estudiantes',
            'editar estudiantes',
            'eliminar estudiantes',
            'generar reporte estudiantes',

            // Fase 4: Padres/Representantes
            'gestionar padres',
            'ver padres',
            'crear padres',
            'editar padres',
            'eliminar padres',
            'generar reporte padres',

            // Fase 5: Paralelos
            'gestionar paralelos',
            'ver paralelos',
            'crear paralelos',
            'editar paralelos',
            'eliminar paralelos',
            'generar reporte paralelos',

            // Fase 5: Asignaciones (Curso-Materia)
            'gestionar asignaciones',
            'ver asignaciones',
            'crear asignaciones',
            'editar asignaciones',
            'eliminar asignaciones',
            'generar reporte asignaciones',

            // Fase 5: Asignaciones Docente-Materia con Horarios
            'gestionar asignaciones docentes',
            'ver asignaciones docentes',
            'crear asignaciones docentes',
            'editar asignaciones docentes',
            'eliminar asignaciones docentes',
            'generar reporte asignaciones docentes',

            // Fase 5: Solicitudes de Matrícula
            'ver solicitudes matricula',
            'aprobar solicitudes matricula',
            'rechazar solicitudes matricula',
            'gestionar solicitudes matricula',

            // Fase 5: Órdenes de Pago
            'ver ordenes pago',
            'aprobar ordenes pago',
            'rechazar ordenes pago',
            'gestionar ordenes pago',

            // Fase 5: Configuración de Matrículas
            'gestionar configuracion matriculas',
            'ver configuracion matriculas',
            'editar configuracion matriculas',

            // Fase 5: Matrículas
            'ver matriculas',
            'crear matriculas',
            'editar matriculas',
            'eliminar matriculas',
            'gestionar matriculas',
            'generar reporte matriculas',

            // Fase 5: Carpeta Académica
            'generar carpeta academica',
            'ver carpeta academica',

            // Fase 6: Calificaciones
            'gestionar calificaciones',
            'ver calificaciones',
            'registrar calificaciones',
            'editar calificaciones',
            'eliminar calificaciones',
            'publicar calificaciones',
            'generar reporte calificaciones',

            // Fase 6: Componentes de Calificación
            'gestionar componentes',
            'ver componentes',
            'crear componentes',
            'editar componentes',
            'eliminar componentes',

            // Fase 8: Asistencias
            'gestionar asistencias',
            'ver asistencias',
            'crear asistencias',
            'registrar asistencias',
            'editar asistencias',
            'eliminar asistencias',
            'registrar asistencia masiva',
            'generar reporte asistencias',

            // Fase 8: Justificaciones
            'gestionar justificaciones',
            'ver justificaciones',
            'crear justificaciones',
            'editar justificaciones',
            'eliminar justificaciones',
            'aprobar justificaciones',
            'rechazar justificaciones',
            'generar reporte justificaciones',

            // Fase 9: Tareas
            'gestionar tareas',
            'ver tareas',
            'crear tareas',
            'editar tareas',
            'eliminar tareas',
            'calificar tareas',
            'completar tareas',
            'generar reporte tareas',

            // Fase 10: Mensajes
            'gestionar mensajes',
            'ver mensajes',
            'enviar mensajes',
            'editar mensajes',
            'eliminar mensajes',
            'enviar mensajes masivos',

            // Fase 10: Notificaciones
            'gestionar notificaciones',
            'ver notificaciones',
            'crear notificaciones',
            'eliminar notificaciones',
            'marcar notificaciones leidas',

            // Fase 11: Eventos
            'gestionar eventos',
            'ver eventos',
            'crear eventos',
            'editar eventos',
            'eliminar eventos',
            'confirmar asistencia eventos',
            'ver calendario eventos',
            'generar reporte eventos',

            // Fase 12: Horarios
            'gestionar horarios',
            'ver horarios',
            'crear horarios',
            'editar horarios',
            'eliminar horarios',
            'ver horario paralelo',
            'ver horario docente',
            'ver horario aula',
            'generar reporte horarios',

            // Fase 13: Auditoría
            'gestionar auditoria',
            'ver auditoria',
            'ver historial registro',
            'ver actividad usuario',
            'ver estadisticas auditoria',
            'limpiar auditoria',
            'exportar auditoria',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole->givePermissionTo($permissions);
        $estudianteRole->givePermissionTo(['ver dashboard']);
        $profesorRole->givePermissionTo(['ver dashboard']);
        $representanteRole->givePermissionTo(['ver dashboard']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'institucion_id' => 1,
                'name' => 'Pablo Jiménez',
                'password' => bcrypt('password'), // Cambia esto por una contraseña segura
                'cedula' => '1004549976',
                'telefono' => '123-456-7890',
                'direccion' => 'Dirección de ejemplo',
                'foto' => null,
                'fecha_nacimiento' => '2003-12-07',
                'estado' => 'activo',
                'ultimo_acceso' => null,
                'intentos_fallidos' => 0,
            ]
        );

        // Usuario de prueba para la segunda institución
        $adminUser2 = User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'institucion_id' => 2,
                'name' => 'Laura Vélez',
                'password' => bcrypt('password'),
                'cedula' => '1004549977',
                'telefono' => '098-765-4321',
                'direccion' => 'San Cristóbal, Galápagos',
                'foto' => null,
                'fecha_nacimiento' => '1985-03-15',
                'estado' => 'activo',
                'ultimo_acceso' => null,
                'intentos_fallidos' => 0,
            ]
        );

        $adminUser2->assignRole($adminRole);

        $adminUser->assignRole($adminRole);
    }
}
