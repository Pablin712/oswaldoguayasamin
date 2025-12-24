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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paralelo_id')->constrained('paralelos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('aula_id')->nullable()->constrained('aulas')->onDelete('set null');
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
            $table->enum('dia_semana', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();

            // Índices para consultas frecuentes
            $table->index(['paralelo_id', 'dia_semana']);
            $table->index(['docente_id', 'dia_semana']);
            $table->index(['aula_id', 'dia_semana']);

            // Evitar conflictos de horario en el mismo paralelo
            $table->unique(['paralelo_id', 'dia_semana', 'hora_inicio', 'periodo_academico_id'], 'unique_horario_paralelo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
