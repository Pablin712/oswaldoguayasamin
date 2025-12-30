<?php

namespace Database\Seeders;

use App\Models\Tarea;
use App\Models\ArchivoTarea;
use App\Models\TareaEstudiante;
use App\Models\Docente;
use App\Models\DocenteMateria;
use App\Models\Estudiante;
use App\Models\Matricula;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener asignaciones de docentes
        $asignaciones = DocenteMateria::with(['docente', 'materia', 'paralelo'])
            ->get();

        if ($asignaciones->isEmpty()) {
            $this->command->warn('No hay asignaciones de docentes. Ejecuta primero AsignacionesAcademicasSeeder.');
            return;
        }

        $tareasCreadas = 0;
        $archivosCreados = 0;
        $tareasEstudianteCreadas = 0;

        foreach ($asignaciones->take(30) as $asignacion) {
            // Crear 2-4 tareas por cada asignación
            $numTareas = rand(2, 4);

            for ($i = 0; $i < $numTareas; $i++) {
                $fechaAsignacion = Carbon::now()->subDays(rand(1, 30));
                $diasParaEntrega = rand(3, 14);

                $esCalificada = rand(1, 100) <= 70; // 70% son calificadas

                $tarea = Tarea::create([
                    'docente_id' => $asignacion->docente_id,
                    'materia_id' => $asignacion->materia_id,
                    'paralelo_id' => $asignacion->paralelo_id,
                    'titulo' => $this->getTituloAleatorio($asignacion->materia->nombre),
                    'descripcion' => $this->getDescripcionAleatoria(),
                    'fecha_asignacion' => $fechaAsignacion,
                    'fecha_entrega' => $fechaAsignacion->copy()->addDays($diasParaEntrega),
                    'es_calificada' => $esCalificada,
                    'puntaje_maximo' => $esCalificada ? 10.00 : null,
                ]);

                $tareasCreadas++;

                // Crear 0-2 archivos adjuntos
                $numArchivos = rand(0, 2);
                for ($j = 0; $j < $numArchivos; $j++) {
                    ArchivoTarea::create([
                        'tarea_id' => $tarea->id,
                        'nombre_archivo' => 'material_' . $tarea->id . '_' . ($j + 1) . '.pdf',
                        'ruta_archivo' => 'tareas/archivos/' . $tarea->id . '/material_' . ($j + 1) . '.pdf',
                        'tipo_mime' => 'application/pdf',
                        'tamanio' => rand(50000, 5000000), // 50KB a 5MB
                    ]);

                    $archivosCreados++;
                }

                // Obtener estudiantes matriculados en ese paralelo
                $matriculas = Matricula::where('paralelo_id', $asignacion->paralelo_id)
                    ->where('estado', 'activa')
                    ->with('estudiante')
                    ->get();

                foreach ($matriculas as $matricula) {
                    // 80% completan la tarea
                    $completada = rand(1, 100) <= 80;

                    $estado = 'pendiente';
                    $fechaCompletada = null;
                    $calificacion = null;
                    $comentarios = null;
                    $fechaRevision = null;

                    if ($completada) {
                        // Fecha de completado entre fecha asignación y entrega
                        $diasHastaEntrega = $fechaAsignacion->diffInDays($tarea->fecha_entrega);
                        $diaCompletado = rand(1, max(1, $diasHastaEntrega));
                        $fechaCompletada = $fechaAsignacion->copy()->addDays($diaCompletado);

                        $estado = 'completada';

                        // 70% de las completadas están revisadas
                        if (rand(1, 100) <= 70) {
                            $estado = 'revisada';
                            $fechaRevision = $fechaCompletada->copy()->addDays(rand(1, 3));

                            if ($tarea->es_calificada) {
                                // Generar calificación entre 5 y 10
                                $calificacion = rand(50, 100) / 10;
                                $comentarios = $this->getComentarioAleatorio($calificacion);
                            }
                        }
                    }

                    TareaEstudiante::create([
                        'tarea_id' => $tarea->id,
                        'estudiante_id' => $matricula->estudiante_id,
                        'estado' => $estado,
                        'fecha_completada' => $fechaCompletada,
                        'calificacion' => $calificacion,
                        'comentarios_docente' => $comentarios,
                        'fecha_revision' => $fechaRevision,
                    ]);

                    $tareasEstudianteCreadas++;
                }
            }
        }

        $this->command->info("✅ Se crearon $tareasCreadas tareas");
        $this->command->info("✅ Se crearon $archivosCreados archivos adjuntos");
        $this->command->info("✅ Se crearon $tareasEstudianteCreadas registros de tareas por estudiante");
    }

    /**
     * Obtener un título aleatorio para la tarea
     */
    private function getTituloAleatorio(string $materia): string
    {
        $titulos = [
            'Matemática' => [
                'Resolver ejercicios de álgebra',
                'Problemas de geometría',
                'Ejercicios de fracciones',
                'Tarea de ecuaciones lineales',
            ],
            'Lengua y Literatura' => [
                'Lectura y análisis del capítulo',
                'Redacción de ensayo',
                'Análisis de texto literario',
                'Ejercicios de ortografía',
            ],
            'Ciencias Naturales' => [
                'Investigación sobre el ecosistema',
                'Experimento de laboratorio',
                'Cuadro comparativo de especies',
                'Informe científico',
            ],
            'Estudios Sociales' => [
                'Línea de tiempo histórica',
                'Mapa conceptual de la región',
                'Investigación histórica',
                'Análisis de fuentes primarias',
            ],
            'default' => [
                'Tarea práctica',
                'Trabajo de investigación',
                'Ejercicios del tema',
                'Proyecto de aula',
            ],
        ];

        $categoria = $titulos[$materia] ?? $titulos['default'];
        return $categoria[array_rand($categoria)];
    }

    /**
     * Obtener descripción aleatoria
     */
    private function getDescripcionAleatoria(): string
    {
        $descripciones = [
            'Completar los ejercicios de las páginas indicadas en el libro de texto.',
            'Realizar la actividad siguiendo las instrucciones proporcionadas en clase.',
            'Desarrollar el trabajo en equipos de 3-4 estudiantes.',
            'Investigar el tema y preparar una presentación.',
            'Resolver todos los problemas propuestos mostrando el proceso.',
            'Leer el material y responder las preguntas al final del capítulo.',
        ];

        return $descripciones[array_rand($descripciones)];
    }

    /**
     * Obtener comentario aleatorio según calificación
     */
    private function getComentarioAleatorio(float $calificacion): string
    {
        if ($calificacion >= 9) {
            $comentarios = [
                'Excelente trabajo, demuestra dominio del tema.',
                'Muy bien realizado, sigue así.',
                'Trabajo sobresaliente.',
            ];
        } elseif ($calificacion >= 7) {
            $comentarios = [
                'Buen trabajo, pero puede mejorar.',
                'Cumple con lo solicitado.',
                'Trabajo satisfactorio.',
            ];
        } else {
            $comentarios = [
                'Necesita reforzar los conceptos.',
                'Debe poner más atención a los detalles.',
                'Revisar el tema nuevamente.',
            ];
        }

        return $comentarios[array_rand($comentarios)];
    }
}
