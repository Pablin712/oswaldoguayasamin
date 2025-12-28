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
