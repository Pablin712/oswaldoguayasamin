<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\CursoMateria;
use App\Models\Materia;
use App\Models\Paralelo;
use App\Models\PeriodoAcademico;
use Illuminate\Database\Seeder;

class RelacionesAcademicasSeeder extends Seeder
{
    public function run(): void
    {
        $periodo = PeriodoAcademico::where('estado', 'activo')->first();

        if (!$periodo) {
            $this->command->warn('No hay período académico activo. Ejecuta EstructuraAcademicaSeeder primero.');
            return;
        }

        // 1. Crear Paralelos para cada curso
        $cursos = Curso::all();

        foreach ($cursos as $curso) {
            // Crear paralelos A, B y C para cada curso
            Paralelo::create([
                'curso_id' => $curso->id,
                'periodo_academico_id' => $periodo->id,
                'nombre' => 'A',
                'cupo_maximo' => 30,
            ]);

            Paralelo::create([
                'curso_id' => $curso->id,
                'periodo_academico_id' => $periodo->id,
                'nombre' => 'B',
                'cupo_maximo' => 30,
            ]);

            // Solo algunos cursos tienen paralelo C
            if ($curso->orden <= 10) { // Solo Básica
                Paralelo::create([
                    'curso_id' => $curso->id,
                    'periodo_academico_id' => $periodo->id,
                    'nombre' => 'C',
                    'cupo_maximo' => 30,
                ]);
            }
        }

        // 2. Asignar materias a cursos según el nivel
        $materias = Materia::all()->keyBy('codigo');

        // Materias comunes para todos los niveles
        $materiasComunes = [
            'MAT-001' => 5, // Matemáticas - 5 horas
            'LEN-001' => 5, // Lengua - 5 horas
            'ING-001' => 3, // Inglés - 3 horas
            'EF-001' => 2,  // Educación Física - 2 horas
            'ECA-001' => 2, // Arte - 2 horas
        ];

        // Materias para Educación Básica (1ro a 10mo)
        $materiasBasica = array_merge($materiasComunes, [
            'CN-001' => 4,  // Ciencias Naturales - 4 horas
            'SS-001' => 3,  // Estudios Sociales - 3 horas
        ]);

        // Materias para Bachillerato (1ro a 3ro)
        $materiasBachillerato = array_merge($materiasComunes, [
            'FIS-001' => 4, // Física - 4 horas
            'QUI-001' => 4, // Química - 4 horas
            'BIO-001' => 3, // Biología - 3 horas
            'FIL-001' => 2, // Filosofía - 2 horas
            'EC-001' => 2,  // Educación Ciudadanía - 2 horas
        ]);

        foreach ($cursos as $curso) {
            // Seleccionar materias según el nivel
            $materiasAsignar = $curso->nivel === 'Bachillerato' ? $materiasBachillerato : $materiasBasica;

            foreach ($materiasAsignar as $codigo => $horas) {
                if (isset($materias[$codigo])) {
                    CursoMateria::create([
                        'curso_id' => $curso->id,
                        'materia_id' => $materias[$codigo]->id,
                        'periodo_academico_id' => $periodo->id,
                        'horas_semanales' => $horas,
                    ]);
                }
            }
        }

        $this->command->info('Relaciones académicas creadas exitosamente!');
        $this->command->info('- Paralelos: ' . Paralelo::count());
        $this->command->info('- Asignaciones Curso-Materia: ' . CursoMateria::count());
    }
}
