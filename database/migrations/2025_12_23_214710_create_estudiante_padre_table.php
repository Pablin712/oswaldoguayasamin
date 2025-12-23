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
        Schema::create('estudiante_padre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('padre_id')->constrained('padres')->onDelete('cascade');
            $table->enum('parentesco', ['padre', 'madre', 'tutor', 'otro']);
            $table->boolean('es_principal')->default(false);
            $table->timestamps();

            // Índice único para evitar duplicados
            $table->unique(['estudiante_id', 'padre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_padre');
    }
};
