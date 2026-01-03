<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institucion;
use App\Models\SolicitudMatricula;
use App\Models\Curso;
use App\Models\PeriodoAcademico;
use Carbon\Carbon;

class SolicitudMatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = Institucion::all();
        $cursos = Curso::take(3)->get();

        if ($cursos->isEmpty()) {
            $this->command->warn('No hay cursos. Saltando seeder de solicitudes.');
            return;
        }

        foreach ($instituciones as $institucion) {
            $periodoActual = PeriodoAcademico::where('estado', 'activo')
                ->where('institucion_id', $institucion->id)
                ->first();

            if (!$periodoActual) {
                $this->command->warn("No hay periodo activo para {$institucion->nombre}. Saltando solicitudes.");
                continue;
            }

            // Solicitud 1: Pendiente (estudiante nuevo)
            SolicitudMatricula::create([
                'periodo_academico_id' => $periodoActual->id,
                'curso_solicitado_id' => $cursos[0]->id,
                'nombres' => 'Carlos Andrés',
                'apellidos' => 'Villamar Pérez',
                'cedula' => '2050123' . $institucion->id . '56',
                'email' => "carlos.villamar{$institucion->id}@email.com",
                'telefono' => '0987654321',
                'institucion_origen' => 'Escuela Fiscal Mixta Darwin',
                'observaciones' => 'Estudiante con buen rendimiento académico. Viene de otra institución.',
                'estado' => 'pendiente',
            ]);

            // Solicitud 2: Aprobada (ya se procesó)
            SolicitudMatricula::create([
                'periodo_academico_id' => $periodoActual->id,
                'curso_solicitado_id' => $cursos[1]->id,
                'nombres' => 'Sofía Valentina',
                'apellidos' => 'Moncayo Torres',
                'cedula' => '2050987' . $institucion->id . '54',
                'email' => "sofia.moncayo{$institucion->id}@email.com",
                'telefono' => '0987123456',
                'institucion_origen' => 'Escuela Particular Santa María',
                'observaciones' => 'Transferencia por cambio de domicilio.',
                'estado' => 'aprobada',
                'created_at' => Carbon::now()->subDays(5),
            ]);

            // Solicitud 3: Rechazada (documentación incompleta)
            SolicitudMatricula::create([
                'periodo_academico_id' => $periodoActual->id,
                'curso_solicitado_id' => $cursos[0]->id,
                'nombres' => 'Diego Alejandro',
                'apellidos' => 'Ponce Ruiz',
                'cedula' => '2050555' . $institucion->id . '66',
                'email' => "diego.ponce{$institucion->id}@email.com",
                'telefono' => '0983334455',
                'institucion_origen' => 'No especificado',
                'observaciones' => 'Documentación incompleta.',
                'estado' => 'rechazada',
                'created_at' => Carbon::now()->subDays(10),
            ]);

            // Solicitud 4: Pendiente (otro estudiante nuevo)
            SolicitudMatricula::create([
                'periodo_academico_id' => $periodoActual->id,
                'curso_solicitado_id' => $cursos[2]->id,
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Morales Castro',
                'cedula' => '2050777' . $institucion->id . '88',
                'email' => "ana.morales{$institucion->id}@email.com",
                'telefono' => '0986667788',
                'institucion_origen' => 'Colegio Nacional Galápagos',
                'observaciones' => 'Primera matrícula. Estudiante destacado en matemáticas.',
                'estado' => 'pendiente',
                'created_at' => Carbon::now()->subDays(2),
            ]);
        }

        $this->command->info('✓ Solicitudes de matrícula creadas exitosamente.');
    }
}
