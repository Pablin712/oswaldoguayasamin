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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('codigo_docente', 20)->unique();
            $table->string('titulo_profesional')->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->enum('tipo_contrato', ['nombramiento', 'contrato'])->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'licencia'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
