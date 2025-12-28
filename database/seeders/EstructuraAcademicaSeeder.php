<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Aula;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\Parcial;
use App\Models\PeriodoAcademico;
use App\Models\Quimestre;
use Illuminate\Database\Seeder;

class EstructuraAcademicaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Período Académico 2024-2025
        $periodo = PeriodoAcademico::create([
            'nombre' => '2024-2025',
            'fecha_inicio' => '2024-09-01',
            'fecha_fin' => '2025-06-30',
            'estado' => 'activo',
        ]);

        // 2. Crear Quimestres
        $quimestre1 = Quimestre::create([
            'periodo_academico_id' => $periodo->id,
            'nombre' => 'Primer Quimestre',
            'numero' => 1,
            'fecha_inicio' => '2024-09-01',
            'fecha_fin' => '2025-01-31',
        ]);

        $quimestre2 = Quimestre::create([
            'periodo_academico_id' => $periodo->id,
            'nombre' => 'Segundo Quimestre',
            'numero' => 2,
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-06-30',
        ]);

        // 3. Crear Parciales para Quimestre 1
        Parcial::create([
            'quimestre_id' => $quimestre1->id,
            'nombre' => 'Primer Parcial',
            'numero' => 1,
            'fecha_inicio' => '2024-09-01',
            'fecha_fin' => '2024-10-15',
            'permite_edicion' => true,
        ]);

        Parcial::create([
            'quimestre_id' => $quimestre1->id,
            'nombre' => 'Segundo Parcial',
            'numero' => 2,
            'fecha_inicio' => '2024-10-16',
            'fecha_fin' => '2024-11-30',
            'permite_edicion' => true,
        ]);

        Parcial::create([
            'quimestre_id' => $quimestre1->id,
            'nombre' => 'Tercer Parcial',
            'numero' => 3,
            'fecha_inicio' => '2024-12-01',
            'fecha_fin' => '2025-01-31',
            'permite_edicion' => true,
        ]);

        // 4. Crear Parciales para Quimestre 2
        Parcial::create([
            'quimestre_id' => $quimestre2->id,
            'nombre' => 'Primer Parcial',
            'numero' => 1,
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-03-15',
            'permite_edicion' => true,
        ]);

        Parcial::create([
            'quimestre_id' => $quimestre2->id,
            'nombre' => 'Segundo Parcial',
            'numero' => 2,
            'fecha_inicio' => '2025-03-16',
            'fecha_fin' => '2025-04-30',
            'permite_edicion' => true,
        ]);

        Parcial::create([
            'quimestre_id' => $quimestre2->id,
            'nombre' => 'Tercer Parcial',
            'numero' => 3,
            'fecha_inicio' => '2025-05-01',
            'fecha_fin' => '2025-06-30',
            'permite_edicion' => true,
        ]);

        // 5. Crear Cursos (Educación Básica y Bachillerato)
        $cursos = [
            ['nombre' => '1ro de Básica', 'nivel' => 'Educación Básica', 'orden' => 1],
            ['nombre' => '2do de Básica', 'nivel' => 'Educación Básica', 'orden' => 2],
            ['nombre' => '3ro de Básica', 'nivel' => 'Educación Básica', 'orden' => 3],
            ['nombre' => '4to de Básica', 'nivel' => 'Educación Básica', 'orden' => 4],
            ['nombre' => '5to de Básica', 'nivel' => 'Educación Básica', 'orden' => 5],
            ['nombre' => '6to de Básica', 'nivel' => 'Educación Básica', 'orden' => 6],
            ['nombre' => '7mo de Básica', 'nivel' => 'Educación Básica', 'orden' => 7],
            ['nombre' => '8vo de Básica', 'nivel' => 'Educación Básica', 'orden' => 8],
            ['nombre' => '9no de Básica', 'nivel' => 'Educación Básica', 'orden' => 9],
            ['nombre' => '10mo de Básica', 'nivel' => 'Educación Básica', 'orden' => 10],
            ['nombre' => '1ro de Bachillerato', 'nivel' => 'Bachillerato', 'orden' => 11],
            ['nombre' => '2do de Bachillerato', 'nivel' => 'Bachillerato', 'orden' => 12],
            ['nombre' => '3ro de Bachillerato', 'nivel' => 'Bachillerato', 'orden' => 13],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }

        // 6. Crear Materias
        $areaMatematicas = Area::where('nombre', 'Matemáticas')->first();
        $areaLengua = Area::where('nombre', 'Lengua y Literatura')->first();
        $areaCiencias = Area::where('nombre', 'Ciencias Naturales')->first();
        $areaSociales = Area::where('nombre', 'Ciencias Sociales')->first();
        $areaExtranjera = Area::where('nombre', 'Lengua Extranjera')->first();
        $areaFisica = Area::where('nombre', 'Educación Física')->first();
        $areaCultural = Area::where('nombre', 'Educación Cultural y Artística')->first();
        $areaCiudadania = Area::where('nombre', 'Educación para la Ciudadanía')->first();

        $materias = [
            ['nombre' => 'Matemáticas', 'codigo' => 'MAT-001', 'area_id' => $areaMatematicas->id, 'color' => '#3B82F6'],
            ['nombre' => 'Lengua y Literatura', 'codigo' => 'LEN-001', 'area_id' => $areaLengua->id, 'color' => '#EF4444'],
            ['nombre' => 'Ciencias Naturales', 'codigo' => 'CN-001', 'area_id' => $areaCiencias->id, 'color' => '#10B981'],
            ['nombre' => 'Estudios Sociales', 'codigo' => 'SS-001', 'area_id' => $areaSociales->id, 'color' => '#F59E0B'],
            ['nombre' => 'Inglés', 'codigo' => 'ING-001', 'area_id' => $areaExtranjera->id, 'color' => '#8B5CF6'],
            ['nombre' => 'Educación Física', 'codigo' => 'EF-001', 'area_id' => $areaFisica->id, 'color' => '#EC4899'],
            ['nombre' => 'Educación Cultural y Artística', 'codigo' => 'ECA-001', 'area_id' => $areaCultural->id, 'color' => '#F97316'],
            ['nombre' => 'Física', 'codigo' => 'FIS-001', 'area_id' => $areaMatematicas->id, 'color' => '#06B6D4'],
            ['nombre' => 'Química', 'codigo' => 'QUI-001', 'area_id' => $areaCiencias->id, 'color' => '#14B8A6'],
            ['nombre' => 'Biología', 'codigo' => 'BIO-001', 'area_id' => $areaCiencias->id, 'color' => '#22C55E'],
            ['nombre' => 'Filosofía', 'codigo' => 'FIL-001', 'area_id' => $areaSociales->id, 'color' => '#A855F7'],
            ['nombre' => 'Educación para la Ciudadanía', 'codigo' => 'EC-001', 'area_id' => $areaCiudadania->id, 'color' => '#64748B'],
        ];

        foreach ($materias as $materia) {
            Materia::create($materia);
        }

        // 7. Crear Aulas
        $aulas = [
            ['nombre' => 'Aula 101', 'capacidad' => 30, 'edificio' => 'Principal', 'piso' => 1],
            ['nombre' => 'Aula 102', 'capacidad' => 30, 'edificio' => 'Principal', 'piso' => 1],
            ['nombre' => 'Aula 103', 'capacidad' => 30, 'edificio' => 'Principal', 'piso' => 1],
            ['nombre' => 'Aula 201', 'capacidad' => 35, 'edificio' => 'Principal', 'piso' => 2],
            ['nombre' => 'Aula 202', 'capacidad' => 35, 'edificio' => 'Principal', 'piso' => 2],
            ['nombre' => 'Aula 203', 'capacidad' => 35, 'edificio' => 'Principal', 'piso' => 2],
            ['nombre' => 'Laboratorio Ciencias', 'capacidad' => 25, 'edificio' => 'Secundario', 'piso' => 1],
            ['nombre' => 'Laboratorio Computación', 'capacidad' => 30, 'edificio' => 'Secundario', 'piso' => 1],
            ['nombre' => 'Biblioteca', 'capacidad' => 50, 'edificio' => 'Secundario', 'piso' => 1],
            ['nombre' => 'Auditorio', 'capacidad' => 200, 'edificio' => 'Secundario', 'piso' => 2],
        ];

        foreach ($aulas as $aula) {
            Aula::create($aula);
        }

        $this->command->info('Estructura académica creada exitosamente!');
    }
}
