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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remitente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destinatario_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['individual', 'masivo', 'anuncio'])->default('individual');
            $table->string('asunto');
            $table->text('cuerpo');
            $table->boolean('es_leido')->default(false);
            $table->timestamp('fecha_lectura')->nullable();
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('programado_para')->nullable();
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index('remitente_id');
            $table->index('destinatario_id');
            $table->index('fecha_envio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
