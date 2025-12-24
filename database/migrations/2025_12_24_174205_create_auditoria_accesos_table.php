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
        Schema::create('auditoria_accesos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('accion', 100); // create, update, delete, login, logout, view, etc.
            $table->string('tabla_afectada', 100)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Índices para consultas de auditoría
            $table->index(['user_id', 'created_at']);
            $table->index(['tabla_afectada', 'registro_id']);
            $table->index(['accion', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_accesos');
    }
};
