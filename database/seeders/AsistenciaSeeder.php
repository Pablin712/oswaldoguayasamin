<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Justificacion;
use App\Models\Padre;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los estudiantes activos
        $estudiantes = Estudiante::with('user')->get();

        // Obtener el primer docente para registrar asistencias
        $docente = Docente::first();

        if (!$docente) {
            $this->command->warn('No hay docentes en la base de datos. Ejecuta primero DocenteSeeder.');
            return;
        }

        // Obtener paralelos
        $paralelos = Paralelo::all();

        if ($paralelos->isEmpty()) {
            $this->command->warn('No hay paralelos en la base de datos.');
            return;
        }

        // Generar asistencias de los últimos 30 días
        $fechaInicio = Carbon::now()->subDays(30);
        $fechaFin = Carbon::now();

        $asistenciasCreadas = 0;
        $justificacionesCreadas = 0;

        foreach ($paralelos as $paralelo) {
            // Filtrar estudiantes del paralelo (los primeros N estudiantes para este ejemplo)
            $estudiantesParalelo = $estudiantes->random(min(5, $estudiantes->count()));

            for ($fecha = $fechaInicio->copy(); $fecha <= $fechaFin; $fecha->addDay()) {
                // Solo días de semana (lunes a viernes)
                if ($fecha->isWeekend()) {
                    continue;
                }

                foreach ($estudiantesParalelo as $estudiante) {
                    // 85% de probabilidad de asistencia
                    $estadoProbabilidad = rand(1, 100);

                    if ($estadoProbabilidad <= 85) {
                        $estado = 'presente';
                    } elseif ($estadoProbabilidad <= 92) {
                        $estado = 'atrasado';
                    } else {
                        $estado = 'ausente';
                    }

                    $asistencia = Asistencia::create([
                        'estudiante_id' => $estudiante->id,
                        'paralelo_id' => $paralelo->id,
                        'materia_id' => null, // Asistencia general del día
                        'docente_id' => $docente->id,
                        'fecha' => $fecha->toDateString(),
                        'hora' => $fecha->copy()->setTime(8, 0)->toTimeString(),
                        'estado' => $estado,
                        'observaciones' => $estado === 'atrasado' ? 'Llegó 15 minutos tarde' : null,
                    ]);

                    $asistenciasCreadas++;

                    // Si hay ausencia, crear justificación en algunos casos (50% de las ausencias)
                    if ($estado === 'ausente' && rand(1, 100) <= 50) {
                        // Obtener un padre del estudiante
                        $padre = $estudiante->padres()->first();

                        if ($padre) {
                            $justificacion = Justificacion::create([
                                'asistencia_id' => $asistencia->id,
                                'padre_id' => $padre->id,
                                'motivo' => $this->getMotivoAleatorio(),
                                'archivo_adjunto' => rand(1, 100) <= 30 ? 'justificaciones/certificado_' . $asistencia->id . '.pdf' : null,
                                'estado' => $this->getEstadoJustificacion(),
                                'revisado_por' => rand(1, 100) <= 70 ? 1 : null, // 70% revisadas
                                'fecha_revision' => rand(1, 100) <= 70 ? $fecha->copy()->addHours(rand(2, 24)) : null,
                            ]);

                            $justificacionesCreadas++;

                            // Si la justificación fue aprobada, actualizar estado de asistencia
                            if ($justificacion->estado === 'aprobada') {
                                $asistencia->update(['estado' => 'justificado']);
                            }
                        }
                    }
                }
            }
        }

        $this->command->info("✅ Se crearon $asistenciasCreadas asistencias");
        $this->command->info("✅ Se crearon $justificacionesCreadas justificaciones");
    }

    /**
     * Obtener un motivo aleatorio para la justificación
     */
    private function getMotivoAleatorio(): string
    {
        $motivos = [
            'Cita médica',
            'Enfermedad leve (gripe)',
            'Enfermedad estomacal',
            'Asunto familiar urgente',
            'Consulta odontológica',
            'Problemas de transporte',
            'Fiebre',
            'Malestar general',
            'Viaje familiar',
            'Calamidad doméstica',
        ];

        return $motivos[array_rand($motivos)];
    }

    /**
     * Obtener estado aleatorio para justificación
     */
    private function getEstadoJustificacion(): string
    {
        $probabilidad = rand(1, 100);

        if ($probabilidad <= 70) {
            return 'aprobada';
        } elseif ($probabilidad <= 85) {
            return 'pendiente';
        } else {
            return 'rechazada';
        }
    }
}
