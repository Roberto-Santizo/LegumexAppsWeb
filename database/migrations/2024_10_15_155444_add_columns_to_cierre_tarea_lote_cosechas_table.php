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
            $table->float('plantas_cosechadas');
            $table->float('libras_total_finca')->nullable();
            $table->float('libras_total_planta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cierre_tarea_lote_cosechas', function (Blueprint $table) {
            $table->dropColumn('plantas_cosechadas');
            $table->dropColumn('libras_total_finca');
            $table->dropColumn('libras_total_planta');
        });
    }
};
