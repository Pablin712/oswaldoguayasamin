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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('paralelo_id')->constrained('paralelos')->onDelete('cascade');
            $table->foreignId('materia_id')->nullable()->constrained('materias')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->enum('estado', ['presente', 'ausente', 'atrasado', 'justificado'])->default('presente');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['estudiante_id', 'fecha']);
            $table->index(['paralelo_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
