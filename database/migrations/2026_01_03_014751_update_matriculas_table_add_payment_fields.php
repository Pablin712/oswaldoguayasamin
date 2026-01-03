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
        Schema::table('matriculas', function (Blueprint $table) {
            // Agregar tipo de matrícula
            $table->enum('tipo_matricula', ['primera', 'segunda'])->default('primera')->after('fecha_matricula');

            // Relación con orden de pago
            $table->foreignId('orden_pago_id')->nullable()->after('tipo_matricula')->constrained('ordenes_pago')->onDelete('set null');

            // Relación con solicitud de matrícula (si es estudiante externo)
            $table->foreignId('solicitud_matricula_id')->nullable()->after('orden_pago_id')->constrained('solicitudes_matricula')->onDelete('set null');

            // Cambiar estados de matrícula
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'activa', 'retirada', 'trasladada', 'finalizada'])->default('pendiente')->change();

            // Agregar fecha y usuario que aprobó
            $table->timestamp('fecha_aprobacion')->nullable()->after('estado');
            $table->foreignId('aprobado_por')->nullable()->after('fecha_aprobacion')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('aprobado_por');
            $table->dropColumn('fecha_aprobacion');
            $table->enum('estado', ['activa', 'retirada', 'trasladada', 'finalizada'])->default('activa')->change();
            $table->dropConstrainedForeignId('solicitud_matricula_id');
            $table->dropConstrainedForeignId('orden_pago_id');
            $table->dropColumn('tipo_matricula');
        });
    }
};
