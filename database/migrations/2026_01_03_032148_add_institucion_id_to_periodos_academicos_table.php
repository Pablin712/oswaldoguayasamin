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
        Schema::table('periodos_academicos', function (Blueprint $table) {
            $table->foreignId('institucion_id')->nullable()->after('id')->constrained('instituciones')->onDelete('cascade');
            $table->index(['institucion_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodos_academicos', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropIndex(['institucion_id', 'estado']);
            $table->dropColumn('institucion_id');
        });
    }
};
