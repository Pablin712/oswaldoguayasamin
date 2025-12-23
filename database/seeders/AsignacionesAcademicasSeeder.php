<?php

namespace Database\Seeders;

use App\Models\DocenteMateria;
use App\Models\Matricula;
use App\Models\Calificacion;
use App\Models\ComponenteCalificacion;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\CursoMateria;
use App\Models\Paralelo;
use App\Models\PeriodoAcademico;
use App\Models\Parcial;
use Illuminate\Database\Seeder;

class AsignacionesAcademicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodoActual = PeriodoAcademico::where('estado', 'activo')->first();

        if (!$periodoActual) {
            $this->command->error('No hay un período académico activo');
            return;
        }

        // 1. Asignar docentes a materias por paralelo
        $docentes = Docente::all();
        $paralelos = Paralelo::where('periodo_academico_id', $periodoActual->id)->get();

        $asignacionesCount = 0;
        foreach ($paralelos as $paralelo) {
            // Obtener las materias asignadas al curso de este paralelo
            $cursoMaterias = CursoMateria::where('curso_id', $paralelo->curso_id)
                ->where('periodo_academico_id', $periodoActual->id)
                ->get();

            foreach ($cursoMaterias as $cursoMateria) {
                // Asignar un docente aleatorio (en un sistema real, sería según especialidad)
                $docente = $docentes->random();

                DocenteMateria::create([
                    'docente_id' => $docente->id,
                    'curso_materia_id' => $cursoMateria->id,
                    'paralelo_id' => $paralelo->id,
                    'periodo_academico_id' => $periodoActual->id,
                ]);

                $asignacionesCount++;
            }
        }

        // 2. Matricular estudiantes en paralelos
        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $matriculasCount = 0;

        foreach ($estudiantes as $index => $estudiante) {
            // Asignar cada estudiante a un paralelo aleatorio
            $paralelo = $paralelos->random();

            $matricula = Matricula::create([
                'estudiante_id' => $estudiante->id,
                'paralelo_id' => $paralelo->id,
                'periodo_academico_id' => $periodoActual->id,
                'numero_matricula' => 'MAT-' . $periodoActual->nombre . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'fecha_matricula' => now()->subDays(rand(30, 60)),
                'estado' => 'activa',
            ]);

            $matriculasCount++;

            // 3. Generar calificaciones para el estudiante matriculado
            $parciales = Parcial::whereHas('quimestre', function ($query) use ($periodoActual) {
                $query->where('periodo_academico_id', $periodoActual->id);
            })->get();

            // Obtener las materias del curso del paralelo
            $cursoMaterias = CursoMateria::where('curso_id', $paralelo->curso_id)
                ->where('periodo_academico_id', $periodoActual->id)
                ->get();

            foreach ($cursoMaterias as $cursoMateria) {
                // Obtener el docente asignado
                $docenteMateria = DocenteMateria::where('curso_materia_id', $cursoMateria->id)
                    ->where('paralelo_id', $paralelo->id)
                    ->first();

                if (!$docenteMateria) continue;

                foreach ($parciales as $parcial) {
                    // Generar nota aleatoria entre 7.00 y 10.00
                    $notaFinal = rand(700, 1000) / 100;

                    $calificacion = Calificacion::create([
                        'matricula_id' => $matricula->id,
                        'curso_materia_id' => $cursoMateria->id,
                        'parcial_id' => $parcial->id,
                        'docente_id' => $docenteMateria->docente_id,
                        'nota_final' => $notaFinal,
                        'fecha_registro' => now()->subDays(rand(1, 20)),
                        'estado' => 'publicada',
                    ]);

                    // 4. Generar componentes de calificación
                    $componentes = [
                        ['nombre' => 'Tareas', 'tipo' => 'tarea', 'porcentaje' => 20],
                        ['nombre' => 'Lecciones', 'tipo' => 'leccion', 'porcentaje' => 20],
                        ['nombre' => 'Trabajo en Clase', 'tipo' => 'participacion', 'porcentaje' => 20],
                        ['nombre' => 'Examen Parcial', 'tipo' => 'examen', 'porcentaje' => 40],
                    ];

                    foreach ($componentes as $comp) {
                        ComponenteCalificacion::create([
                            'calificacion_id' => $calificacion->id,
                            'nombre' => $comp['nombre'],
                            'tipo' => $comp['tipo'],
                            'nota' => rand(700, 1000) / 100,
                            'porcentaje' => $comp['porcentaje'],
                        ]);
                    }
                }
            }
        }

        $this->command->info('✓ Asignaciones académicas y calificaciones creadas correctamente');
        $this->command->info("  - $asignacionesCount Asignaciones docente-materia-paralelo");
        $this->command->info("  - $matriculasCount Matrículas de estudiantes");
        $this->command->info('  - Calificaciones generadas por estudiante, materia y parcial');
        $this->command->info('  - Componentes de calificación desglosados (Tareas, Lecciones, Exámenes)');
    }
}
