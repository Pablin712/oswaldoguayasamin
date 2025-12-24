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
        Schema::create('tarea_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'completada', 'revisada'])->default('pendiente');
            $table->timestamp('fecha_completada')->nullable();
            $table->decimal('calificacion', 4, 2)->nullable();
            $table->text('comentarios_docente')->nullable();
            $table->timestamp('fecha_revision')->nullable();
            $table->timestamps();

            // Constraint único: un estudiante solo puede tener un registro por tarea
            $table->unique(['tarea_id', 'estudiante_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_estudiante');
    }
};
