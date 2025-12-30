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
        Schema::create('docente_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('paralelo_id')->constrained('paralelos')->onDelete('cascade');
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
            $table->string('rol', 50)->default('Principal'); // Principal, Auxiliar, Practicante, Suplente, Co-teaching
            $table->timestamps();

            // Constraint único: el MISMO docente no puede estar asignado DOS VECES a la misma materia/paralelo
            // pero DIFERENTES docentes SÍ pueden estar asignados a la misma materia/paralelo
            $table->unique(['docente_id', 'materia_id', 'paralelo_id', 'periodo_academico_id'], 'unique_asignacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_materia');
    }
};
