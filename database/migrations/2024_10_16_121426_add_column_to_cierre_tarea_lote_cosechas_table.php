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
        Schema::table('cierre_tarea_lote_cosechas', function (Blueprint $table) {
            $table->foreignId('asignacion_diaria_cosechas_id')->references('id')->on('asignacion_diaria_cosechas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cierre_tarea_lote_cosechas', function (Blueprint $table) {
            $table->dropForeign('cierre_tarea_lote_cosechas_asignacion_diaria_cosechas_id_foreign');
            $table->dropColumn('asignacion_diaria_cosechas_id');
        });
    }
};
