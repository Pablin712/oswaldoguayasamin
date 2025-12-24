<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use App\Models\PeriodoAcademico;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que exista al menos un período académico
        $periodo = PeriodoAcademico::first();

        if (!$periodo) {
            $this->command->warn('No hay períodos académicos registrados. Crea uno primero.');
            return;
        }

        // Crear configuración para cada institución
        $instituciones = \App\Models\Institucion::all();

        foreach ($instituciones as $institucion) {
            Configuracion::updateOrCreate(
                ['institucion_id' => $institucion->id],
                [
            // Académico
            'periodo_actual_id' => $periodo->id,
            'numero_quimestres' => 2,
            'numero_parciales' => 3,
            'fecha_inicio_clases' => now()->startOfYear()->addMonths(8), // Septiembre
            'fecha_fin_clases' => now()->startOfYear()->addYear()->addMonths(6), // Julio siguiente
            'fecha_inicio_q1' => now()->startOfYear()->addMonths(8),
            'fecha_fin_q1' => now()->startOfYear()->addMonths(12),
            'fecha_inicio_q2' => now()->startOfYear()->addYear()->addMonths(1),
            'fecha_fin_q2' => now()->startOfYear()->addYear()->addMonths(6),
            'porcentaje_minimo_asistencia' => 75.00,

            // Calificaciones
            'calificacion_minima' => 0.00,
            'calificacion_maxima' => 10.00,
            'nota_minima_aprobacion' => 7.00,
            'decimales' => 2,
            'ponderacion_examen' => 20.00,
            'ponderacion_parciales' => 80.00,
            'permitir_supletorio' => true,
            'permitir_remedial' => true,
            'permitir_gracia' => false,
            'redondear_calificaciones' => false,

            // Horarios
            'duracion_periodo' => 40,
            'duracion_recreo' => 15,
            'periodos_por_dia' => 8,
            'dias_laborales' => ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'],

            // Correo
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_encriptacion' => 'tls',
            'smtp_usuario' => null,
            'smtp_password' => null,
            'remitente_nombre' => 'Sistema Académico',
            'remitente_email' => null,

            // Notificaciones
            'notificar_calificaciones' => true,
            'notificar_asistencia' => true,
            'notificar_eventos' => true,
            'resumen_semanal_padres' => false,
            'resumen_mensual_docentes' => false,
            'plantilla_correo' => 'Estimado/a @{{nombre}},\n\n@{{mensaje}}\n\nSaludos cordiales,\n@{{institucion}}',
            ]);
        }

        $this->command->info('Configuraciones creadas para ' . $instituciones->count() . ' institución(es).');
    }
}
