<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade')->unique();

            // Configuración Académica
            $table->unsignedBigInteger('periodo_actual_id')->nullable();
            $table->integer('numero_quimestres')->default(2);
            $table->integer('numero_parciales')->default(3);
            $table->date('fecha_inicio_clases')->nullable();
            $table->date('fecha_fin_clases')->nullable();
            $table->date('fecha_inicio_q1')->nullable();
            $table->date('fecha_fin_q1')->nullable();
            $table->date('fecha_inicio_q2')->nullable();
            $table->date('fecha_fin_q2')->nullable();
            $table->integer('porcentaje_minimo_asistencia')->default(75);

            // Configuración Calificaciones
            $table->decimal('calificacion_minima', 5, 2)->default(0);
            $table->decimal('calificacion_maxima', 5, 2)->default(10);
            $table->decimal('nota_minima_aprobacion', 5, 2)->default(7);
            $table->integer('decimales')->default(2);
            $table->integer('ponderacion_examen')->default(20); // %
            $table->integer('ponderacion_parciales')->default(80); // %
            $table->boolean('permitir_supletorio')->default(true);
            $table->boolean('permitir_remedial')->default(true);
            $table->boolean('permitir_gracia')->default(true);
            $table->boolean('redondear_calificaciones')->default(false);

            // Configuración Horarios
            $table->integer('duracion_periodo')->default(45); // minutos
            $table->integer('duracion_recreo')->default(15); // minutos
            $table->integer('periodos_por_dia')->default(6);
            $table->json('dias_laborales')->nullable(); // ["Lunes", "Martes", ...]

            // Configuración SMTP
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->default(587);
            $table->enum('smtp_encriptacion', ['TLS', 'SSL'])->default('TLS');
            $table->string('smtp_usuario')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('remitente_nombre')->nullable();
            $table->string('remitente_email')->nullable();

            // Configuración Notificaciones
            $table->boolean('notificar_calificaciones')->default(true);
            $table->boolean('notificar_asistencia')->default(true);
            $table->boolean('notificar_eventos')->default(true);
            $table->boolean('resumen_semanal_padres')->default(false);
            $table->boolean('resumen_mensual_docentes')->default(false);
            $table->text('plantilla_correo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};
