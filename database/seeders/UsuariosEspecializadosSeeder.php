<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Padre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosEspecializadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * IMPORTANTE: Este seeder crea usuarios con su CÉDULA como contraseña inicial.
     * El sistema forzará el cambio de contraseña en el primer acceso mediante
     * el middleware EnsurePasswordIsChanged.
     *
     * Credenciales de ejemplo:
     * - Email: docente1@guayasamin.edu.ec
     * - Password: 1301234567 (su cédula)
     */
    public function run(): void
    {
        // 1. Crear docentes (8 profesores)
        $docentes = [
            ['name' => 'Dr. Carlos Mendoza', 'cedula' => '1301234567', 'especialidad' => 'Matemáticas', 'titulo' => 'Doctor en Educación Matemática'],
            ['name' => 'Lcda. María García', 'cedula' => '1301234568', 'especialidad' => 'Lengua y Literatura', 'titulo' => 'Licenciada en Pedagogía'],
            ['name' => 'Ing. Roberto Salazar', 'cedula' => '1301234569', 'especialidad' => 'Ciencias Naturales', 'titulo' => 'Ingeniero Químico'],
            ['name' => 'Lcda. Ana Morales', 'cedula' => '1301234570', 'especialidad' => 'Estudios Sociales', 'titulo' => 'Licenciada en Historia'],
            ['name' => 'Prof. Luis Torres', 'cedula' => '1301234571', 'especialidad' => 'Educación Física', 'titulo' => 'Profesor de Educación Física'],
            ['name' => 'Lcda. Carmen Vega', 'cedula' => '1301234572', 'especialidad' => 'Inglés', 'titulo' => 'Licenciada en Lenguas Extranjeras'],
            ['name' => 'Ing. Diego Páez', 'cedula' => '1301234573', 'especialidad' => 'Informática', 'titulo' => 'Ingeniero en Sistemas'],
            ['name' => 'Lcda. Patricia Ruiz', 'cedula' => '1301234574', 'especialidad' => 'Artes', 'titulo' => 'Licenciada en Artes Plásticas'],
        ];

        foreach ($docentes as $index => $docenteData) {
            $user = User::create([
                'name' => $docenteData['name'],
                'email' => 'docente' . ($index + 1) . '@guayasamin.edu.ec',
                'password' => Hash::make($docenteData['cedula']), // Usa cédula como contraseña inicial
                'cedula' => $docenteData['cedula'],
                'telefono' => '0987654' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'direccion' => 'Puerto Ayora, Galápagos',
                'fecha_nacimiento' => now()->subYears(rand(30, 55))->format('Y-m-d'),
                'estado' => 'activo',
            ]);

            $user->assignRole('profesor');

            Docente::create([
                'user_id' => $user->id,
                'codigo_docente' => 'DOC-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'titulo_profesional' => $docenteData['titulo'],
                'especialidad' => $docenteData['especialidad'],
                'fecha_ingreso' => now()->subYears(rand(1, 10))->format('Y-m-d'),
                'tipo_contrato' => $index < 5 ? 'nombramiento' : 'contrato',
                'estado' => 'activo',
            ]);
        }

        // 2. Crear padres (20 padres/madres)
        $padres = [];
        for ($i = 1; $i <= 20; $i++) {
            $genero = $i % 2 == 0 ? 'F' : 'M';
            $prefijo = $genero == 'M' ? 'Sr.' : 'Sra.';
            $nombres = [
                'M' => ['Juan', 'Pedro', 'Luis', 'Carlos', 'Miguel', 'Jorge', 'Roberto', 'Fernando', 'Daniel', 'Ricardo'],
                'F' => ['María', 'Ana', 'Carmen', 'Rosa', 'Laura', 'Patricia', 'Isabel', 'Sofía', 'Lucía', 'Gabriela'],
            ];
            $apellidos = ['González', 'Rodríguez', 'López', 'Martínez', 'Sánchez', 'Pérez', 'Torres', 'Ramírez', 'Flores', 'Cruz'];

            $nombre = $nombres[$genero][($i - 1) % 10] . ' ' . $apellidos[($i - 1) % 10];

            $user = User::create([
                'name' => $prefijo . ' ' . $nombre,
                'email' => 'padre' . $i . '@email.com',
                'password' => Hash::make('130' . str_pad($i + 5000, 7, '0', STR_PAD_LEFT)), // Usa cédula como contraseña
                'cedula' => '130' . str_pad($i + 5000, 7, '0', STR_PAD_LEFT),
                'telefono' => '0987' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'direccion' => 'Puerto Ayora, Galápagos',
                'fecha_nacimiento' => now()->subYears(rand(35, 60))->format('Y-m-d'),
                'estado' => 'activo',
            ]);

            $user->assignRole('representante');

            $padre = Padre::create([
                'user_id' => $user->id,
                'ocupacion' => ['Comerciante', 'Empleado Público', 'Guía Turístico', 'Pescador', 'Agricultor', 'Profesional Independiente'][$i % 6],
                'lugar_trabajo' => 'Puerto Ayora',
                'telefono_trabajo' => '05252' . str_pad($i, 4, '0', STR_PAD_LEFT),
            ]);

            $padres[] = $padre;
        }

        // 3. Crear estudiantes (40 estudiantes)
        $tiposSangre = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $nombresEstudiantes = [
            'M' => ['Juan Pablo', 'Diego', 'Mateo', 'Santiago', 'Sebastián', 'Andrés', 'Nicolás', 'Daniel', 'Gabriel', 'Miguel', 'David', 'Carlos', 'Luis', 'Fernando', 'Ricardo', 'Javier', 'Alejandro', 'Francisco', 'Manuel', 'Eduardo'],
            'F' => ['María José', 'Sofía', 'Valentina', 'Isabella', 'Camila', 'Martina', 'Lucía', 'Victoria', 'Emma', 'Mía', 'Paula', 'Daniela', 'Carolina', 'Andrea', 'Gabriela', 'Natalia', 'Laura', 'Ana', 'Sara', 'Elena'],
        ];

        for ($i = 1; $i <= 40; $i++) {
            $genero = $i % 2 == 0 ? 'F' : 'M';
            $nombreCompleto = $nombresEstudiantes[$genero][($i - 1) % 20] . ' ' . $apellidos[($i - 1) % 10];

            $user = User::create([
                'name' => $nombreCompleto,
                'email' => 'estudiante' . $i . '@guayasamin.edu.ec',
                'password' => Hash::make('130' . str_pad($i + 3000, 7, '0', STR_PAD_LEFT)), // Usa cédula como contraseña
                'cedula' => '130' . str_pad($i + 3000, 7, '0', STR_PAD_LEFT),
                'telefono' => '0986' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'direccion' => 'Puerto Ayora, Galápagos',
                'fecha_nacimiento' => now()->subYears(rand(6, 18))->format('Y-m-d'),
                'estado' => 'activo',
            ]);

            $user->assignRole('estudiante');

            $estudiante = Estudiante::create([
                'user_id' => $user->id,
                'codigo_estudiante' => 'EST-' . now()->year . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'fecha_ingreso' => now()->subYears(rand(1, 5))->format('Y-m-d'),
                'tipo_sangre' => $tiposSangre[$i % 8],
                'alergias' => $i % 5 == 0 ? 'Alergia a mariscos' : null,
                'contacto_emergencia' => $padres[($i * 2 - 2) % 20]->user->name,
                'telefono_emergencia' => $padres[($i * 2 - 2) % 20]->user->telefono,
                'estado' => 'activo',
            ]);

            // Vincular estudiante con padres (cada estudiante tiene 2 padres)
            $padre1 = $padres[($i * 2 - 2) % 20]; // Padre principal
            $padre2 = $padres[($i * 2 - 1) % 20]; // Madre

            DB::table('estudiante_padre')->insert([
                [
                    'estudiante_id' => $estudiante->id,
                    'padre_id' => $padre1->id,
                    'parentesco' => 'padre',
                    'es_principal' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'estudiante_id' => $estudiante->id,
                    'padre_id' => $padre2->id,
                    'parentesco' => 'madre',
                    'es_principal' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $this->command->info('✓ Usuarios especializados creados correctamente');
        $this->command->info('  - 8 Docentes');
        $this->command->info('  - 20 Padres/Madres');
        $this->command->info('  - 40 Estudiantes (cada uno vinculado a 2 padres)');
    }
}
