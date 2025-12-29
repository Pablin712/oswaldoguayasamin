<?php

namespace Database\Seeders;

use App\Models\Padre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $padres = [
            [
                'institucion_id' => 1,
                'name' => 'María López González',
                'cedula' => '0987654321',
                'email' => 'maria.lopez@gmail.com',
                'telefono' => '0987654322',
                'fecha_nacimiento' => '1985-05-10',
                'direccion' => 'Av. Principal #123, Quito',
                'ocupacion' => 'Ingeniera Civil',
                'lugar_trabajo' => 'Constructora ABC',
                'telefono_trabajo' => '022345678',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Carlos González Ruiz',
                'cedula' => '0987654323',
                'email' => 'carlos.gonzalez@gmail.com',
                'telefono' => '0987654324',
                'fecha_nacimiento' => '1982-08-22',
                'direccion' => 'Calle Secundaria #456, Quito',
                'ocupacion' => 'Médico',
                'lugar_trabajo' => 'Hospital Metropolitano',
                'telefono_trabajo' => '022345679',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Ana Morales Pérez',
                'cedula' => '0987654325',
                'email' => 'ana.morales@gmail.com',
                'telefono' => '0987654326',
                'fecha_nacimiento' => '1988-12-15',
                'direccion' => 'Av. Libertad #789, Quito',
                'ocupacion' => 'Profesora',
                'lugar_trabajo' => 'Colegio Nacional',
                'telefono_trabajo' => '022345680',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Luis Torres Sánchez',
                'cedula' => '0987654327',
                'email' => 'luis.torres@gmail.com',
                'telefono' => '0987654328',
                'fecha_nacimiento' => '1980-03-28',
                'direccion' => 'Calle Norte #321, Quito',
                'ocupacion' => 'Comerciante',
                'lugar_trabajo' => 'Negocio Propio',
                'telefono_trabajo' => '0987654329',
            ],
            [
                'institucion_id' => 2,
                'name' => 'Roberto Mendoza Castro',
                'cedula' => '0987654331',
                'email' => 'roberto.mendoza@gmail.com',
                'telefono' => '0987654332',
                'fecha_nacimiento' => '1983-06-18',
                'direccion' => 'Calle Este #987, Guayaquil',
                'ocupacion' => 'Abogado',
                'lugar_trabajo' => 'Estudio Jurídico Mendoza',
                'telefono_trabajo' => '042345681',
            ],
        ];

        foreach ($padres as $padreData) {
            // Crear usuario
            $user = User::create([
                'institucion_id' => $padreData['institucion_id'],
                'name' => $padreData['name'],
                'cedula' => $padreData['cedula'],
                'email' => $padreData['email'],
                'password' => Hash::make($padreData['cedula']), // La cédula es la contraseña inicial
                'telefono' => $padreData['telefono'],
                'fecha_nacimiento' => $padreData['fecha_nacimiento'],
                'direccion' => $padreData['direccion'],
                'estado' => 'activo',
            ]);

            // Asignar rol de representante
            $user->assignRole('representante');

            // Crear padre/representante
            Padre::create([
                'user_id' => $user->id,
                'ocupacion' => $padreData['ocupacion'],
                'lugar_trabajo' => $padreData['lugar_trabajo'],
                'telefono_trabajo' => $padreData['telefono_trabajo'],
            ]);
        }
    }
}
