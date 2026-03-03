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
        $asignaciones = DocenteMateria::with(['docente.user', 'materia', 'paralelo.curso', 'paralelo.aula'])
            ->where('periodo_academico_id', $periodoActivo->id)
            ->get();

        if ($asignaciones->isEmpty()) {
            $this->command->warn('No hay asignaciones de docentes. Ejecuta AsignacionesAcademicasSeeder primero.');
            return;
        }

        $this->command->info("Asignaciones encontradas: " . $asignaciones->count());

        // Limpiar horarios existentes para evitar duplicados
        Horario::whereHas('docenteMateria', function($q) use ($periodoActivo) {
            $q->where('periodo_academico_id', $periodoActivo->id);
        })->delete();

        // Horarios base para clases (8:00 - 13:00, bloques de 40 minutos con 10 min de descanso)
        // RECESO: 10:20 - 10:50 (30 minutos)
        $bloquesHorarios = [
            ['inicio' => '08:00:00', 'fin' => '08:40:00'],
            ['inicio' => '08:50:00', 'fin' => '09:30:00'],
            ['inicio' => '09:40:00', 'fin' => '10:20:00'],
            // RECESO DE 30 MINUTOS: 10:20 - 10:50
            ['inicio' => '10:50:00', 'fin' => '11:30:00'], // Después del recreo
            ['inicio' => '11:40:00', 'fin' => '12:20:00'],
            ['inicio' => '12:30:00', 'fin' => '13:10:00'],
        ];

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        $horariosCreados = 0;
        $horariosOmitidos = 0;

        // Agrupar asignaciones por paralelo
        $asignacionesPorParalelo = $asignaciones->groupBy('paralelo_id');

        foreach ($asignacionesPorParalelo as $paraleloId => $asignacionesParalelo) {
            $primeraAsignacion = $asignacionesParalelo->first();
            $paralelo = $primeraAsignacion->paralelo;

            $this->command->info("\nProcesando: {$paralelo->curso->nombre} {$paralelo->nombre}");

            if (!$paralelo->aula_id) {
                $this->command->warn("  ⚠ Sin aula asignada, omitiendo...");
                continue;
            }

            $bloqueActual = 0;
            $diaActual = 0;

            foreach ($asignacionesParalelo as $asignacion) {
                // Verificar que tenga la materia relacionada
                if (!$asignacion->materia) {
                    continue;
                }

                // Obtener las horas semanales desde curso_materia
                $cursoMateria = \App\Models\CursoMateria::where('curso_id', $paralelo->curso_id)
                    ->where('materia_id', $asignacion->materia_id)
                    ->where('periodo_academico_id', $periodoActivo->id)
                    ->first();

                $horasSemanales = $cursoMateria?->horas_semanales ?? 2;
                $bloquesNecesarios = min($horasSemanales, 5); // Máximo 5 bloques por materia

                $this->command->info("  - {$asignacion->materia->nombre}: {$bloquesNecesarios} bloques/semana");

                for ($i = 0; $i < $bloquesNecesarios; $i++) {
                    // Si nos quedamos sin bloques en el día, pasar al siguiente día
                    if ($bloqueActual >= count($bloquesHorarios)) {
                        $bloqueActual = 0;
                        $diaActual++;

                        // Si nos quedamos sin días, empezar de nuevo
                        if ($diaActual >= count($diasSemana)) {
                            $this->command->warn("    ⚠ Sin espacios disponibles para más bloques");
                            break;
                        }
                    }

                    $horario = $bloquesHorarios[$bloqueActual];

                    try {
                        Horario::create([
                            'docente_materia_id' => $asignacion->id,
                            'dia_semana' => $diasSemana[$diaActual],
                            'hora_inicio' => $horario['inicio'],
                            'hora_fin' => $horario['fin'],
                        ]);
                        $horariosCreados++;
                    } catch (\Exception $e) {
                        // Si hay conflicto, intentar en el siguiente bloque
                        $this->command->warn("    ⚠ Conflicto detectado: {$e->getMessage()}");
                        $horariosOmitidos++;
                    }

                    $bloqueActual++;
                }
            }
        }

        $totalHorarios = Horario::count();
        $this->command->info("\n" . str_repeat('=', 50));
        $this->command->info("✓ Resumen de Horarios:");
        $this->command->info("  - Total creados: {$horariosCreados}");
        $this->command->info("  - Omitidos por conflicto: {$horariosOmitidos}");
        $this->command->info("  - Total en base de datos: {$totalHorarios}");

        // Mostrar estadísticas por día
        $this->command->info("\n📅 Distribución por día:");
        foreach ($diasSemana as $dia) {
            $count = Horario::where('dia_semana', $dia)->count();
            $this->command->info("  - {$dia}: {$count} clases");
        }

        // Estadísticas por paralelo
        $this->command->info("\n🏫 Paralelos con horarios:");
        $paralelosConHorarios = Horario::with('paralelo.curso')
            ->get()
            ->groupBy('paralelo_id');

        foreach ($paralelosConHorarios as $paraleloId => $horarios) {
            $paralelo = $horarios->first()->paralelo;
            $this->command->info("  - {$paralelo->curso->nombre} {$paralelo->nombre}: {$horarios->count()} clases");
        }

        // Estadísticas por aula
        $this->command->info("\n🚪 Aulas en uso:");
        $aulasConHorarios = Horario::with('paralelo.aula')
            ->get()
            ->filter(function($h) { return $h->paralelo && $h->paralelo->aula; })
            ->groupBy(function($h) { return $h->paralelo->aula_id; });

        foreach ($aulasConHorarios as $aulaId => $horarios) {
            $aula = $horarios->first()->paralelo->aula;
            $this->command->info("  - {$aula->nombre}: {$horarios->count()} clases");
        }
    }
}
