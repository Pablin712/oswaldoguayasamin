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
        Schema::create('paralelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('nombre', 10);
            $table->integer('cupo_maximo')->nullable();
            $table->foreignId('aula_id')->nullable()->constrained('aulas')->onDelete('set null');
            $table->timestamps();

            // Índice único para curso + nombre (ej: 1ro Básica + A)
            $table->unique(['curso_id', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paralelos');
    }
};
