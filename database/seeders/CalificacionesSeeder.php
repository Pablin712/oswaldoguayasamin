<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matricula;
use App\Models\Calificacion;
use App\Models\ComponenteCalificacion;
use App\Models\DocenteMateria;
use App\Models\CursoMateria;
use App\Models\Paralelo;
use App\Models\PeriodoAcademico;
use App\Models\Parcial;
use Illuminate\Support\Facades\DB;

class CalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el periodo académico activo o el más reciente
        $periodoActivo = PeriodoAcademico::where('estado', 'activo')->first();

        if (!$periodoActivo) {
            $periodoActivo = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->first();
            $this->command->warn("No hay período activo. Usando el más reciente: {$periodoActivo->nombre}");
        } else {
            $this->command->info("Usando período activo: {$periodoActivo->nombre}");
        }

        if (!$periodoActivo) {
            $this->command->error('No hay períodos académicos en la base de datos');
            return;
        }

        // Obtener un parcial del período
        $parcial = Parcial::whereHas('quimestre', function($q) use ($periodoActivo) {
            $q->where('periodo_academico_id', $periodoActivo->id);
        })->first();

        if (!$parcial) {
            $this->command->error('No hay parciales en el período seleccionado');
            return;
        }

        $this->command->info("Usando parcial: {$parcial->nombre}");

        // Limpiar calificaciones existentes para regenerar datos de prueba
        $this->command->warn("Limpiando calificaciones existentes...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ComponenteCalificacion::truncate();
        Calificacion::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->command->info("✅ Calificaciones limpiadas");

        // Obtener las matrículas activas del período
        $matriculas = Matricula::where('periodo_academico_id', $periodoActivo->id)
            ->where('estado', 'activa')
            ->with(['paralelo.curso', 'estudiante.user'])
            ->get();

        $this->command->info("Matrículas activas en período {$periodoActivo->nombre}: {$matriculas->count()}");

        $this->command->info("Creando calificaciones para {$matriculas->count()} estudiantes...");

        $calificacionesCreadas = 0;
        $componentesCreados = 0;
        $saltosPorFaltaDocente = 0;
        $saltosPorExistente = 0;

        foreach ($matriculas as $matricula) {
            $paralelo = $matricula->paralelo;

            // Obtener las materias de este curso
            $cursoMaterias = CursoMateria::where('curso_id', $paralelo->curso_id)
                ->where('periodo_academico_id', $periodoActivo->id)
                ->with('materia')
                ->get();

            foreach ($cursoMaterias as $cursoMateria) {
                // Verificar si hay un docente asignado a esta materia en este paralelo
                $docenteMateria = DocenteMateria::where('materia_id', $cursoMateria->materia_id)
                    ->where('paralelo_id', $paralelo->id)
                    ->where('periodo_academico_id', $periodoActivo->id)
                    ->first();

                if (!$docenteMateria) {
                    $saltosPorFaltaDocente++;
                    continue; // Saltar si no hay docente asignado
                }

                // Verificar si ya existe una calificación
                $calificacionExistente = Calificacion::where('matricula_id', $matricula->id)
                    ->where('curso_materia_id', $cursoMateria->id)
                    ->where('parcial_id', $parcial->id)
                    ->exists();

                if ($calificacionExistente) {
                    $saltosPorExistente++;
                    continue; // Saltar si ya existe
                }

                try {
                    // Generar notas aleatorias pero realistas
                    $notaTareas = rand(50, 100) / 10; // 5.0 a 10.0
                    $notaLecciones = rand(50, 100) / 10;
                    $notaTrabajo = rand(50, 100) / 10;
                    $notaExamen = rand(50, 100) / 10;

                // Calcular nota final (20% tareas, 20% lecciones, 20% trabajo, 40% examen)
                $notaFinal = round(
                    ($notaTareas * 0.2) +
                    ($notaLecciones * 0.2) +
                    ($notaTrabajo * 0.2) +
                    ($notaExamen * 0.4),
                    2
                );

                // Determinar estado según la nota
                $estado = 'registrada';
                if (rand(1, 100) > 70) {
                    $estado = 'publicada'; // 30% publicadas
                }

                // Crear la calificación
                $calificacion = Calificacion::create([
                    'matricula_id' => $matricula->id,
                    'curso_materia_id' => $cursoMateria->id,
                    'parcial_id' => $parcial->id,
                    'docente_id' => $docenteMateria->docente_id,
                    'nota_final' => $notaFinal,
                    'observaciones' => $notaFinal < 7 ? 'Requiere refuerzo' : ($notaFinal >= 9 ? 'Excelente desempeño' : null),
                    'fecha_registro' => now(),
                    'estado' => $estado,
                ]);

                $calificacionesCreadas++;

                // Crear componentes de calificación
                $componentes = [
                    ['nombre' => 'Tareas', 'tipo' => 'tarea', 'nota' => $notaTareas, 'porcentaje' => 20],
                    ['nombre' => 'Lecciones', 'tipo' => 'leccion', 'nota' => $notaLecciones, 'porcentaje' => 20],
                    ['nombre' => 'Proyecto', 'tipo' => 'proyecto', 'nota' => $notaTrabajo, 'porcentaje' => 20],
                    ['nombre' => 'Examen', 'tipo' => 'examen', 'nota' => $notaExamen, 'porcentaje' => 40],
                ];

                foreach ($componentes as $comp) {
                    ComponenteCalificacion::create([
                        'calificacion_id' => $calificacion->id,
                        'nombre' => $comp['nombre'],
                        'tipo' => $comp['tipo'],
                        'nota' => $comp['nota'],
                        'porcentaje' => $comp['porcentaje'],
                        'descripcion' => "Evaluación de {$comp['nombre']} - {$cursoMateria->materia->nombre}",
                    ]);
                    $componentesCreados++;
                }
                } catch (\Exception $e) {
                    $this->command->error("Error creando calificación: " . $e->getMessage());
                    $this->command->error("Línea: " . $e->getLine());
                }
            }
        }

        $this->command->info("✅ Seeder completado:");
        $this->command->info("   - {$calificacionesCreadas} calificaciones creadas");
        $this->command->info("   - {$componentesCreados} componentes creados");
        $this->command->info("   - {$saltosPorFaltaDocente} saltos por falta de docente");
        $this->command->info("   - {$saltosPorExistente} saltos por calificación existente");
    }

    /**
     * Crear matrículas de prueba si no existen
     */
    private function crearMatriculas(PeriodoAcademico $periodo): void
    {
        $estudiantes = \App\Models\Estudiante::with('user')->get();
        $paralelos = Paralelo::where('periodo_academico_id', $periodo->id)->get();

        $this->command->info("Estudiantes disponibles: {$estudiantes->count()}");
        $this->command->info("Paralelos en período: {$paralelos->count()}");

        if ($estudiantes->isEmpty()) {
            $this->command->error('No hay estudiantes en la base de datos');
            return;
        }

        if ($paralelos->isEmpty()) {
            $this->command->error("No hay paralelos en el período {$periodo->nombre}");
            return;
        }

        $matriculasCreadas = 0;

        foreach ($estudiantes as $index => $estudiante) {
            // Asignar estudiantes a paralelos de forma distribuida
            $paralelo = $paralelos[$index % $paralelos->count()];

            // Verificar si ya existe una matrícula
            $existe = Matricula::where('estudiante_id', $estudiante->id)
                ->where('periodo_academico_id', $periodo->id)
                ->exists();

            if ($existe) {
                $this->command->warn("Estudiante {$estudiante->user->name} ya tiene matrícula");
                continue;
            }

            Matricula::create([
                'estudiante_id' => $estudiante->id,
                'paralelo_id' => $paralelo->id,
                'periodo_academico_id' => $periodo->id,
                'numero_matricula' => 'MAT-' . $periodo->anio_inicio . '-' . str_pad($matriculasCreadas + 1, 4, '0', STR_PAD_LEFT),
                'fecha_matricula' => now(),
                'tipo_matricula' => 'ordinaria',
                'estado' => 'activo',
                'fecha_aprobacion' => now(),
                'aprobado_por' => 1, // Usuario admin
            ]);
            $matriculasCreadas++;

            $this->command->info("✓ Matrícula creada para {$estudiante->user->name} en {$paralelo->curso->nombre} - {$paralelo->nombre}");
        }

        $this->command->info("✅ {$matriculasCreadas} matrículas creadas");
    }
}
