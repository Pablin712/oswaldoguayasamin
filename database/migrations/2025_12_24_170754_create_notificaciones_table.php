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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo', 50);
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('url')->nullable();
            $table->boolean('es_leida')->default(false);
            $table->boolean('enviar_email')->default(false);
            $table->boolean('email_enviado')->default(false);
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['user_id', 'es_leida']);
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
