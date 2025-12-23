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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole->givePermissionTo($permissions);
        $estudianteRole->givePermissionTo(['ver dashboard']);
        $profesorRole->givePermissionTo(['ver dashboard']);
        $representanteRole->givePermissionTo(['ver dashboard']);

        $adminUser = User::create([
            'name' => 'Pablo Jiménez',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Cambia esto por una contraseña segura
            'cedula' => '1004549976',
            'telefono' => '123-456-7890',
            'direccion' => 'Dirección de ejemplo',
            'foto' => null,
            'fecha_nacimiento' => '2003-12-07',
            'estado' => 'activo',
            'ultimo_acceso' => null,
            'intentos_fallidos' => 0,
        ]);

        $adminUser->assignRole($adminRole);
    }
}
