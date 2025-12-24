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
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->foreignId('institucion_id')->after('id')->constrained('instituciones')->onDelete('cascade');
            $table->unique('institucion_id'); // Una configuración por institución
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropUnique(['institucion_id']);
            $table->dropColumn('institucion_id');
        });
    }
};
