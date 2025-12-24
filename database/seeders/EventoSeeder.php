<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\EventoConfirmacion;
use App\Models\PeriodoAcademico;
use App\Models\Paralelo;
use App\Models\User;
use App\Models\Estudiante;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodoActivo = PeriodoAcademico::where('estado', 'activo')->first();

        if (!$periodoActivo) {
            $this->command->warn('No hay periodo académico activo. Saltando EventoSeeder.');
            return;
        }

        $paralelos = Paralelo::all();
        if ($paralelos->isEmpty()) {
            $this->command->warn('No hay paralelos registrados. Saltando EventoSeeder.');
            return;
        }

        $this->command->info('Creando eventos institucionales...');

        // Eventos del tipo examen
        $examenes = [
            [
                'titulo' => 'Exámenes del Primer Quimestre',
                'descripcion' => 'Periodo de evaluaciones finales del primer quimestre para todos los niveles educativos.',
                'tipo' => 'examen',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(4)->startOfWeek(),
                'fecha_fin' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(4)->addDays(4),
                'hora_inicio' => '08:00',
                'hora_fin' => '12:00',
                'ubicacion' => 'Aulas asignadas',
                'requiere_confirmacion' => false,
                'es_publico' => false,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Exámenes del Segundo Quimestre',
                'descripcion' => 'Periodo de evaluaciones finales del segundo quimestre para todos los niveles educativos.',
                'tipo' => 'examen',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_fin)->subMonths(1)->startOfWeek(),
                'fecha_fin' => Carbon::parse($periodoActivo->fecha_fin)->subMonths(1)->addDays(4),
                'hora_inicio' => '08:00',
                'hora_fin' => '12:00',
                'ubicacion' => 'Aulas asignadas',
                'requiere_confirmacion' => false,
                'es_publico' => false,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Examen de Ubicación - Nuevos Estudiantes',
                'descripcion' => 'Evaluación diagnóstica para estudiantes de nuevo ingreso.',
                'tipo' => 'examen',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->subDays(7),
                'fecha_fin' => null,
                'hora_inicio' => '09:00',
                'hora_fin' => '11:00',
                'ubicacion' => 'Auditorio Principal',
                'requiere_confirmacion' => true,
                'es_publico' => false,
                'paralelos' => $paralelos->random(3)->pluck('id')->toArray(),
            ],
        ];

        // Eventos del tipo reunión
        $reuniones = [
            [
                'titulo' => 'Reunión General de Padres de Familia - Inicio de Periodo',
                'descripcion' => 'Socialización del plan académico y calendario de actividades del periodo lectivo.',
                'tipo' => 'reunion',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addDays(5),
                'fecha_fin' => null,
                'hora_inicio' => '18:00',
                'hora_fin' => '20:00',
                'ubicacion' => 'Auditorio Principal',
                'requiere_confirmacion' => true,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Entrega de Calificaciones - Primer Quimestre',
                'descripcion' => 'Reunión para entrega de libretas y retroalimentación del primer quimestre.',
                'tipo' => 'reunion',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(4)->addDays(10),
                'fecha_fin' => null,
                'hora_inicio' => '16:00',
                'hora_fin' => '19:00',
                'ubicacion' => 'Aulas por paralelo',
                'requiere_confirmacion' => true,
                'es_publico' => false,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Entrega de Calificaciones - Segundo Quimestre',
                'descripcion' => 'Reunión para entrega de libretas finales y retroalimentación del periodo lectivo.',
                'tipo' => 'reunion',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_fin)->addDays(5),
                'fecha_fin' => null,
                'hora_inicio' => '16:00',
                'hora_fin' => '19:00',
                'ubicacion' => 'Aulas por paralelo',
                'requiere_confirmacion' => true,
                'es_publico' => false,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Reunión por Rendimiento Académico',
                'descripcion' => 'Reunión con padres de familia de estudiantes con bajo rendimiento académico.',
                'tipo' => 'reunion',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(2),
                'fecha_fin' => null,
                'hora_inicio' => '15:00',
                'hora_fin' => '17:00',
                'ubicacion' => 'Sala de juntas',
                'requiere_confirmacion' => true,
                'es_publico' => false,
                'paralelos' => $paralelos->random(5)->pluck('id')->toArray(),
            ],
        ];

        // Eventos del tipo actividad
        $actividades = [
            [
                'titulo' => 'Feria de Ciencias y Tecnología',
                'descripcion' => 'Exposición de proyectos científicos y tecnológicos desarrollados por los estudiantes.',
                'tipo' => 'actividad',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(3),
                'fecha_fin' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(3)->addDays(2),
                'hora_inicio' => '09:00',
                'hora_fin' => '15:00',
                'ubicacion' => 'Patio Central',
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Festival Cultural - Día de la Interculturalidad',
                'descripcion' => 'Presentación de danzas, música y gastronomía de las diferentes culturas del Ecuador.',
                'tipo' => 'actividad',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(2)->addDays(15),
                'fecha_fin' => null,
                'hora_inicio' => '10:00',
                'hora_fin' => '14:00',
                'ubicacion' => 'Patio Central',
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Olimpiadas Deportivas Internas',
                'descripcion' => 'Competencias deportivas entre paralelos en diversas disciplinas.',
                'tipo' => 'actividad',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(5),
                'fecha_fin' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(5)->addDays(3),
                'hora_inicio' => '08:00',
                'hora_fin' => '16:00',
                'ubicacion' => 'Cancha deportiva',
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Taller de Primeros Auxilios',
                'descripcion' => 'Capacitación básica en primeros auxilios para docentes, estudiantes y padres de familia.',
                'tipo' => 'actividad',
                'fecha_inicio' => Carbon::now()->addMonths(1),
                'fecha_fin' => null,
                'hora_inicio' => '14:00',
                'hora_fin' => '17:00',
                'ubicacion' => 'Laboratorio de Ciencias',
                'requiere_confirmacion' => true,
                'es_publico' => true,
                'paralelos' => $paralelos->random(4)->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Día de la Familia',
                'descripcion' => 'Jornada recreativa y de integración con actividades para toda la familia.',
                'tipo' => 'actividad',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio)->addMonths(6),
                'fecha_fin' => null,
                'hora_inicio' => '09:00',
                'hora_fin' => '14:00',
                'ubicacion' => 'Instalaciones de la institución',
                'requiere_confirmacion' => true,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
        ];

        // Eventos del tipo ceremonia
        $ceremonias = [
            [
                'titulo' => 'Ceremonia de Inauguración del Año Lectivo',
                'descripcion' => 'Acto solemne de bienvenida e inicio del periodo académico.',
                'tipo' => 'ceremonia',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_inicio),
                'fecha_fin' => null,
                'hora_inicio' => '08:00',
                'hora_fin' => '10:00',
                'ubicacion' => 'Auditorio Principal',
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => $paralelos->pluck('id')->toArray(),
            ],
            [
                'titulo' => 'Ceremonia de Graduación',
                'descripcion' => 'Acto de clausura y graduación de estudiantes de décimo año.',
                'tipo' => 'ceremonia',
                'fecha_inicio' => Carbon::parse($periodoActivo->fecha_fin),
                'fecha_fin' => null,
                'hora_inicio' => '18:00',
                'hora_fin' => '21:00',
                'ubicacion' => 'Auditorio Principal',
                'requiere_confirmacion' => true,
                'es_publico' => true,
                'paralelos' => $paralelos->where('curso.nivel', '10mo')->pluck('id')->toArray() ?: [$paralelos->last()->id],
            ],
        ];

        // Eventos del tipo feriado
        $feriados = [
            [
                'titulo' => 'Feriado - Día del Trabajo',
                'descripcion' => 'Día festivo nacional. No hay clases.',
                'tipo' => 'feriado',
                'fecha_inicio' => Carbon::create($periodoActivo->fecha_inicio->year, 5, 1),
                'fecha_fin' => null,
                'hora_inicio' => null,
                'hora_fin' => null,
                'ubicacion' => null,
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => [],
            ],
            [
                'titulo' => 'Feriado - Batalla de Pichincha',
                'descripcion' => 'Día festivo nacional. No hay clases.',
                'tipo' => 'feriado',
                'fecha_inicio' => Carbon::create($periodoActivo->fecha_inicio->year, 5, 24),
                'fecha_fin' => null,
                'hora_inicio' => null,
                'hora_fin' => null,
                'ubicacion' => null,
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => [],
            ],
            [
                'titulo' => 'Feriado - Primer Grito de Independencia',
                'descripcion' => 'Día festivo nacional. No hay clases.',
                'tipo' => 'feriado',
                'fecha_inicio' => Carbon::create($periodoActivo->fecha_inicio->year, 8, 10),
                'fecha_fin' => null,
                'hora_inicio' => null,
                'hora_fin' => null,
                'ubicacion' => null,
                'requiere_confirmacion' => false,
                'es_publico' => true,
                'paralelos' => [],
            ],
        ];

        // Crear todos los eventos
        $todosEventos = array_merge($examenes, $reuniones, $actividades, $ceremonias, $feriados);

        foreach ($todosEventos as $eventoData) {
            $paralelosIds = $eventoData['paralelos'];
            unset($eventoData['paralelos']);

            $evento = Evento::create([
                'periodo_academico_id' => $periodoActivo->id,
                ...$eventoData,
            ]);

            // Asociar paralelos al evento
            if (!empty($paralelosIds)) {
                $evento->paralelos()->attach($paralelosIds);
            }

            // Si requiere confirmación, crear confirmaciones para usuarios
            if ($evento->requiere_confirmacion) {
                $this->crearConfirmaciones($evento, $paralelosIds);
            }
        }

        $totalEventos = Evento::count();
        $totalConfirmaciones = EventoConfirmacion::count();

        $this->command->info("✓ Eventos creados: {$totalEventos}");
        $this->command->info("✓ Confirmaciones generadas: {$totalConfirmaciones}");
    }

    /**
     * Crear confirmaciones de eventos para usuarios relacionados
     */
    private function crearConfirmaciones($evento, $paralelosIds)
    {
        if (empty($paralelosIds)) {
            // Si no hay paralelos específicos, crear confirmaciones para todos los usuarios con roles
            $usuarios = User::role(['padre', 'docente', 'administrativo'])->get();

            foreach ($usuarios as $usuario) {
                EventoConfirmacion::create([
                    'evento_id' => $evento->id,
                    'user_id' => $usuario->id,
                    'estudiante_id' => null,
                    'confirmado' => fake()->boolean(60), // 60% confirmados
                    'fecha_confirmacion' => fake()->boolean(60) ? now()->subDays(rand(1, 10)) : null,
                    'observaciones' => fake()->boolean(20) ? fake()->sentence() : null,
                ]);
            }
        } else {
            // Crear confirmaciones para padres de estudiantes de los paralelos específicos
            $estudiantes = Estudiante::whereHas('padres', function ($query) {
                $query->whereNotNull('user_id');
            })->with('padres.user')->get();

            foreach ($estudiantes as $estudiante) {
                foreach ($estudiante->padres as $padre) {
                    // Verificar si el padre tiene usuario
                    if (!$padre->user_id) {
                        continue;
                    }

                    EventoConfirmacion::create([
                        'evento_id' => $evento->id,
                        'user_id' => $padre->user_id,
                        'estudiante_id' => $estudiante->id,
                        'confirmado' => fake()->boolean(70), // 70% confirmados
                        'fecha_confirmacion' => fake()->boolean(70) ? now()->subDays(rand(1, 15)) : null,
                        'observaciones' => fake()->boolean(15) ? fake()->sentence() : null,
                    ]);
                }
            }
        }
    }
}
