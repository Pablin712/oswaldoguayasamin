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

            'gestionar usuarios',
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
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
        ]);

        $adminUser->assignRole($adminRole);
    }
}
