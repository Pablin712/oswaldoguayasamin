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
        Schema::create('solicitudes_matricula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->nullable()->constrained('estudiantes')->onDelete('set null');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('cedula', 13)->unique();
            $table->string('email', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('institucion_origen', 255)->nullable();
            $table->foreignId('curso_solicitado_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
            $table->string('adjunto_cedula_path')->nullable();
            $table->string('adjunto_certificado_path')->nullable();
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_revision')->nullable();
            $table->timestamps();

            $table->index(['estado', 'periodo_academico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_matricula');
    }
};
