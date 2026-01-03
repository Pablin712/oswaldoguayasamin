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
        Schema::create('configuracion_matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->enum('tipo_institucion', ['fiscal', 'fiscomisional', 'particular'])->default('fiscal');
            $table->decimal('monto_primera_matricula', 10, 2)->default(0);
            $table->decimal('monto_segunda_matricula', 10, 2)->default(0);
            $table->timestamps();

            $table->unique('institucion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_matriculas');
    }
};
