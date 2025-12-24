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
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_amie', 20)->unique()->nullable();
            $table->string('logo')->nullable();
            $table->enum('tipo', ['Fiscal', 'Fiscomisional', 'Municipal', 'Particular'])->nullable();
            $table->string('nivel')->nullable(); // Ej: "EGB y BGU"
            $table->enum('jornada', ['Matutina', 'Vespertina', 'Nocturna', 'Ambas'])->nullable();
            $table->string('provincia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('canton')->nullable();
            $table->string('parroquia')->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('sitio_web')->nullable();
            $table->string('rector')->nullable();
            $table->string('vicerrector')->nullable();
            $table->string('inspector')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
