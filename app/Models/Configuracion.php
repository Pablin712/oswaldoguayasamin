<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuracion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Académica
        'periodo_actual_id',
        'numero_quimestres',
        'numero_parciales',
        'fecha_inicio_clases',
        'fecha_fin_clases',
        'fecha_inicio_q1',
        'fecha_fin_q1',
        'fecha_inicio_q2',
        'fecha_fin_q2',
        'porcentaje_minimo_asistencia',

        // Calificaciones
        'calificacion_minima',
        'calificacion_maxima',
        'nota_minima_aprobacion',
        'decimales',
        'ponderacion_examen',
        'ponderacion_parciales',
        'permitir_supletorio',
        'permitir_remedial',
        'permitir_gracia',
        'redondear_calificaciones',

        // Horarios
        'duracion_periodo',
        'duracion_recreo',
        'periodos_por_dia',
        'dias_laborales',

        // SMTP
        'smtp_host',
        'smtp_port',
        'smtp_encriptacion',
        'smtp_usuario',
        'smtp_password',
        'remitente_nombre',
        'remitente_email',

        // Notificaciones
        'notificar_calificaciones',
        'notificar_asistencia',
        'notificar_eventos',
        'resumen_semanal_padres',
        'resumen_mensual_docentes',
        'plantilla_correo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio_clases' => 'date',
        'fecha_fin_clases' => 'date',
        'fecha_inicio_q1' => 'date',
        'fecha_fin_q1' => 'date',
        'fecha_inicio_q2' => 'date',
        'fecha_fin_q2' => 'date',
        'calificacion_minima' => 'decimal:2',
        'calificacion_maxima' => 'decimal:2',
        'nota_minima_aprobacion' => 'decimal:2',
        'permitir_supletorio' => 'boolean',
        'permitir_remedial' => 'boolean',
        'permitir_gracia' => 'boolean',
        'redondear_calificaciones' => 'boolean',
        'dias_laborales' => 'array',
        'notificar_calificaciones' => 'boolean',
        'notificar_asistencia' => 'boolean',
        'notificar_eventos' => 'boolean',
        'resumen_semanal_padres' => 'boolean',
        'resumen_mensual_docentes' => 'boolean',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuraciones';

    /**
     * Relación con periodo académico actual.
     */
    public function periodoActual(): BelongsTo
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_actual_id');
    }
}
