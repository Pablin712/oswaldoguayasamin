<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\DocenteMateria;
use App\Models\PeriodoAcademico;
use App\Models\Aula;
use Carbon\Carbon;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodoActivo = PeriodoAcademico::where('estado', 'activo')->first();

        if (!$periodoActivo) {
            $this->command->warn('No hay periodo académico activo. Saltando HorarioSeeder.');
            return;
        }

        $this->command->info('Creando horarios de clases...');

        // Obtener todas las asignaciones de docentes a materias con paralelos
        $asignaciones = DocenteMateria::with(['docente', 'cursoMateria.materia', 'paralelo', 'paralelo.aula'])
            ->where('periodo_academico_id', $periodoActivo->id)
            ->get();

        if ($asignaciones->isEmpty()) {
            $this->command->warn('No hay asignaciones de docentes. Saltando HorarioSeeder.');
            return;
        }

        // Horarios base para clases (8:00 - 13:00, bloques de 40 minutos con 10 min de descanso)
        $bloquesHorarios = [
            ['inicio' => '08:00', 'fin' => '08:40'],
            ['inicio' => '08:50', 'fin' => '09:30'],
            ['inicio' => '09:40', 'fin' => '10:20'],
            ['inicio' => '10:30', 'fin' => '11:10'], // Después del recreo largo
            ['inicio' => '11:20', 'fin' => '12:00'],
            ['inicio' => '12:10', 'fin' => '12:50'],
        ];

        $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];

        // Agrupar asignaciones por paralelo
        $asignacionesPorParalelo = $asignaciones->groupBy('paralelo_id');

        foreach ($asignacionesPorParalelo as $paraleloId => $asignacionesParalelo) {
            $bloqueActual = 0;
            $diaActual = 0;

            foreach ($asignacionesParalelo as $asignacion) {
                // Verificar que tenga la relación cursoMateria
                if (!$asignacion->cursoMateria) {
                    continue;
                }

                // Determinar cuántos bloques necesita esta materia (basado en horas semanales)
                $horasSemanales = $asignacion->cursoMateria->horas_semanales ?? 2;
                $bloquesNecesarios = min($horasSemanales, 5); // Máximo 5 bloques por materia

                for ($i = 0; $i < $bloquesNecesarios; $i++) {
                    // Si nos quedamos sin bloques en el día, pasar al siguiente día
                    if ($bloqueActual >= count($bloquesHorarios)) {
                        $bloqueActual = 0;
                        $diaActual++;

                        // Si nos quedamos sin días, empezar de nuevo (no debería pasar con distribución normal)
                        if ($diaActual >= count($diasSemana)) {
                            break;
                        }
                    }

                    $horario = $bloquesHorarios[$bloqueActual];

                    try {
                        Horario::create([
                            'paralelo_id' => $asignacion->paralelo_id,
                            'materia_id' => $asignacion->cursoMateria->materia_id,
                            'docente_id' => $asignacion->docente_id,
                            'aula_id' => $asignacion->paralelo->aula_id,
                            'periodo_academico_id' => $periodoActivo->id,
                            'dia_semana' => $diasSemana[$diaActual],
                            'hora_inicio' => $horario['inicio'],
                            'hora_fin' => $horario['fin'],
                        ]);
                    } catch (\Exception $e) {
                        // Si hay conflicto, intentar en el siguiente bloque
                        $this->command->warn("Conflicto de horario detectado, ajustando...");
                    }

                    $bloqueActual++;
                }
            }
        }

        $totalHorarios = Horario::count();
        $this->command->info("✓ Horarios creados: {$totalHorarios}");

        // Mostrar estadísticas por día
        $this->command->info("\nDistribución por día:");
        foreach ($diasSemana as $dia) {
            $count = Horario::where('dia_semana', $dia)->count();
            $this->command->info("  - {$dia}: {$count} clases");
        }
    }
}
