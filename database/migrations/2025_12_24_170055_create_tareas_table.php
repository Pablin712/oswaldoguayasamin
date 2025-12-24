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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('paralelo_id')->nullable()->constrained('paralelos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->date('fecha_asignacion');
            $table->date('fecha_entrega');
            $table->boolean('es_calificada')->default(false);
            $table->decimal('puntaje_maximo', 4, 2)->nullable();
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['docente_id', 'fecha_asignacion']);
            $table->index(['paralelo_id', 'fecha_entrega']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
