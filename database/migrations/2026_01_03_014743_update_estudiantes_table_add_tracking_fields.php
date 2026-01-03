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
        Schema::table('estudiantes', function (Blueprint $table) {
            // Cambiar enum de estado para incluir 'transferido'
            $table->enum('estado', ['activo', 'inactivo', 'retirado', 'transferido'])->default('activo')->change();

            // Agregar campo JSON para conteo de matrículas por curso
            $table->json('conteo_matriculas')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'inactivo', 'retirado'])->default('activo')->change();
            $table->dropColumn('conteo_matriculas');
        });
    }
};
