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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('paralelo_id')->constrained('paralelos')->onDelete('cascade');
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
            $table->string('numero_matricula', 50)->unique();
            $table->date('fecha_matricula');
            $table->enum('estado', ['activa', 'retirada', 'trasladada', 'finalizada'])->default('activa');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Un estudiante solo puede tener una matrícula activa por paralelo y período
            $table->unique(['estudiante_id', 'paralelo_id', 'periodo_academico_id'], 'estudiante_paralelo_periodo_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
