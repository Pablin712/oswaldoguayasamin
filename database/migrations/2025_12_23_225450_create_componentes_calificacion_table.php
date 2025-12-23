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
        Schema::create('componentes_calificacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calificacion_id')->constrained('calificaciones')->onDelete('cascade');
            $table->string('nombre', 100); // Tareas, Lecciones, Trabajo en Clase, Proyecto
            $table->enum('tipo', ['tarea', 'leccion', 'examen', 'proyecto', 'participacion', 'otro']);
            $table->decimal('nota', 5, 2);
            $table->decimal('porcentaje', 5, 2); // Porcentaje de la nota final (0-100)
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componentes_calificacion');
    }
};
