<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes = [
            [
                'institucion_id' => 1,
                'name' => 'Juan Carlos Pérez López',
                'cedula' => '1234567890',
                'email' => 'juan.perez@oswaldoguayasamin.edu.ec',
                'telefono' => '0987654321',
                'fecha_nacimiento' => '2010-03-15',
                'direccion' => 'Av. Principal #123, Quito',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'O+',
                'alergias' => null,
                'contacto_emergencia' => 'María López (Madre)',
                'telefono_emergencia' => '0987654322',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'name' => 'María Fernanda González Sánchez',
                'cedula' => '1234567891',
                'email' => 'maria.gonzalez@oswaldoguayasamin.edu.ec',
                'telefono' => '0987654323',
                'fecha_nacimiento' => '2010-07-22',
                'direccion' => 'Calle Secundaria #456, Quito',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'A+',
                'alergias' => 'Polen',
                'contacto_emergencia' => 'Carlos González (Padre)',
                'telefono_emergencia' => '0987654324',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Pedro Alejandro Rodríguez Morales',
                'cedula' => '1234567892',
                'email' => 'pedro.rodriguez@oswaldoguayasamin.edu.ec',
                'telefono' => '0987654325',
                'fecha_nacimiento' => '2011-01-10',
                'direccion' => 'Av. Libertad #789, Quito',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'B+',
                'alergias' => null,
                'contacto_emergencia' => 'Ana Morales (Madre)',
                'telefono_emergencia' => '0987654326',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Ana Lucía Torres Vega',
                'cedula' => '1234567893',
                'email' => 'ana.torres@oswaldoguayasamin.edu.ec',
                'telefono' => '0987654327',
                'fecha_nacimiento' => '2011-05-18',
                'direccion' => 'Calle Norte #321, Quito',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'AB+',
                'alergias' => 'Mariscos',
                'contacto_emergencia' => 'Luis Torres (Padre)',
                'telefono_emergencia' => '0987654328',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'name' => 'Carlos Eduardo Ramírez Díaz',
                'cedula' => '1234567894',
                'email' => 'carlos.ramirez@oswaldoguayasamin.edu.ec',
                'telefono' => '0987654329',
                'fecha_nacimiento' => '2010-11-25',
                'direccion' => 'Av. Sur #654, Quito',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'O-',
                'alergias' => null,
                'contacto_emergencia' => 'Patricia Díaz (Madre)',
                'telefono_emergencia' => '0987654330',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 2,
                'name' => 'Laura Gabriela Mendoza Castro',
                'cedula' => '1234567895',
                'email' => 'laura.mendoza@institucion2.edu.ec',
                'telefono' => '0987654331',
                'fecha_nacimiento' => '2010-09-08',
                'direccion' => 'Calle Este #987, Guayaquil',
                'fecha_ingreso' => '2024-09-01',
                'tipo_sangre' => 'A-',
                'alergias' => 'Penicilina',
                'contacto_emergencia' => 'Roberto Mendoza (Padre)',
                'telefono_emergencia' => '0987654332',
                'estado' => 'activo',
            ],
        ];

        foreach ($estudiantes as $estudianteData) {
            // Crear usuario
            $user = User::create([
                'institucion_id' => $estudianteData['institucion_id'],
                'name' => $estudianteData['name'],
                'cedula' => $estudianteData['cedula'],
                'email' => $estudianteData['email'],
                'password' => Hash::make($estudianteData['cedula']), // La cédula es la contraseña inicial
                'telefono' => $estudianteData['telefono'],
                'fecha_nacimiento' => $estudianteData['fecha_nacimiento'],
                'direccion' => $estudianteData['direccion'],
                'estado' => 'activo',
            ]);

            // Asignar rol de estudiante
            $user->assignRole('estudiante');

            // Generar código de estudiante automático
            $ultimoEstudiante = Estudiante::latest('id')->first();
            $numeroConsecutivo = $ultimoEstudiante ? ((int) substr($ultimoEstudiante->codigo_estudiante, 4)) + 1 : 1;
            $codigoEstudiante = 'EST-' . str_pad($numeroConsecutivo, 4, '0', STR_PAD_LEFT);

            // Crear estudiante
            Estudiante::create([
                'user_id' => $user->id,
                'codigo_estudiante' => $codigoEstudiante,
                'fecha_ingreso' => $estudianteData['fecha_ingreso'],
                'tipo_sangre' => $estudianteData['tipo_sangre'],
                'alergias' => $estudianteData['alergias'],
                'contacto_emergencia' => $estudianteData['contacto_emergencia'],
                'telefono_emergencia' => $estudianteData['telefono_emergencia'],
                'estado' => $estudianteData['estado'],
            ]);
        }
    }
}
