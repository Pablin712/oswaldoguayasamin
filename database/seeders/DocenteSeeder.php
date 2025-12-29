<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Docente;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docentes = [
            [
                'institucion_id' => 1,
                'codigo_docente' => 'DOC-001',
                'nombre_completo' => 'María Elena García López',
                'cedula' => '1712345678',
                'email' => 'maria.garcia@ueog.edu.ec',
                'telefono' => '0987654321',
                'direccion' => 'Av. Principal 123',
                'fecha_nacimiento' => '1985-05-15',
                'titulo_profesional' => 'Licenciada en Educación Matemática',
                'especialidad' => 'Matemáticas',
                'fecha_ingreso' => '2015-09-01',
                'tipo_contrato' => 'nombramiento',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'codigo_docente' => 'DOC-002',
                'nombre_completo' => 'Carlos Alberto Moreno Ruiz',
                'cedula' => '1723456789',
                'email' => 'carlos.moreno@ueog.edu.ec',
                'telefono' => '0976543210',
                'direccion' => 'Calle Secundaria 456',
                'fecha_nacimiento' => '1980-03-22',
                'titulo_profesional' => 'Magíster en Lengua y Literatura',
                'especialidad' => 'Lengua y Literatura',
                'fecha_ingreso' => '2012-02-15',
                'tipo_contrato' => 'nombramiento',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'codigo_docente' => 'DOC-003',
                'nombre_completo' => 'Ana Patricia Sánchez Torres',
                'cedula' => '1734567890',
                'email' => 'ana.sanchez@ueog.edu.ec',
                'telefono' => '0965432109',
                'direccion' => 'Av. Los Pinos 789',
                'fecha_nacimiento' => '1990-11-08',
                'titulo_profesional' => 'Licenciada en Ciencias Naturales',
                'especialidad' => 'Biología',
                'fecha_ingreso' => '2018-09-01',
                'tipo_contrato' => 'contrato',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'codigo_docente' => 'DOC-004',
                'nombre_completo' => 'Luis Fernando Rodríguez Pérez',
                'cedula' => '1745678901',
                'email' => 'luis.rodriguez@ueog.edu.ec',
                'telefono' => '0954321098',
                'direccion' => 'Barrio La Floresta 321',
                'fecha_nacimiento' => '1982-07-14',
                'titulo_profesional' => 'Licenciado en Ciencias Sociales',
                'especialidad' => 'Historia y Geografía',
                'fecha_ingreso' => '2014-01-10',
                'tipo_contrato' => 'nombramiento',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 1,
                'codigo_docente' => 'DOC-005',
                'nombre_completo' => 'Diana Carolina Vásquez Méndez',
                'cedula' => '1756789012',
                'email' => 'diana.vasquez@ueog.edu.ec',
                'telefono' => '0943210987',
                'direccion' => 'Sector Norte 654',
                'fecha_nacimiento' => '1988-12-20',
                'titulo_profesional' => 'Licenciada en Inglés',
                'especialidad' => 'Lengua Extranjera - Inglés',
                'fecha_ingreso' => '2016-09-01',
                'tipo_contrato' => 'contrato',
                'estado' => 'activo',
            ],
            [
                'institucion_id' => 2,
                'codigo_docente' => 'DOC-101',
                'nombre_completo' => 'Roberto Xavier Mendoza Castro',
                'cedula' => '1767890123',
                'email' => 'roberto.mendoza@galapa.edu.ec',
                'telefono' => '0932109876',
                'direccion' => 'San Cristóbal, Galápagos',
                'fecha_nacimiento' => '1983-04-18',
                'titulo_profesional' => 'Licenciado en Educación Física',
                'especialidad' => 'Educación Física',
                'fecha_ingreso' => '2013-09-01',
                'tipo_contrato' => 'nombramiento',
                'estado' => 'activo',
            ],
        ];

        foreach ($docentes as $docenteData) {
            // Crear usuario
            $user = User::create([
                'institucion_id' => $docenteData['institucion_id'],
                'name' => $docenteData['nombre_completo'],
                'email' => $docenteData['email'],
                'password' => Hash::make($docenteData['cedula']),
                'cedula' => $docenteData['cedula'],
                'telefono' => $docenteData['telefono'],
                'direccion' => $docenteData['direccion'],
                'fecha_nacimiento' => $docenteData['fecha_nacimiento'],
                'estado' => 'activo',
            ]);

            // Asignar rol de profesor
            $user->assignRole('profesor');

            // Crear docente
            Docente::create([
                'user_id' => $user->id,
                'codigo_docente' => $docenteData['codigo_docente'],
                'titulo_profesional' => $docenteData['titulo_profesional'],
                'especialidad' => $docenteData['especialidad'],
                'fecha_ingreso' => $docenteData['fecha_ingreso'],
                'tipo_contrato' => $docenteData['tipo_contrato'],
                'estado' => $docenteData['estado'],
            ]);
        }
    }
}
