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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')->constrained('matriculas')->onDelete('cascade');
            $table->foreignId('curso_materia_id')->constrained('curso_materia')->onDelete('cascade');
            $table->foreignId('parcial_id')->constrained('parciales')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->decimal('nota_final', 5, 2);
            $table->text('observaciones')->nullable();
            $table->date('fecha_registro');
            $table->enum('estado', ['registrada', 'modificada', 'aprobada', 'publicada'])->default('registrada');
            $table->timestamps();

            // Una calificación única por matrícula, materia y parcial
            $table->unique(['matricula_id', 'curso_materia_id', 'parcial_id'], 'matricula_materia_parcial_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
