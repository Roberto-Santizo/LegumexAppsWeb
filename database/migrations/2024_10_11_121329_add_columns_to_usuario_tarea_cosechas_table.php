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
        Schema::table('usuario_tarea_cosechas', function (Blueprint $table) {
            $table->float('libras_asignacion')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario_tarea_cosechas', function (Blueprint $table) {
            $table->dropColumn('libras_asignacion');
        });
    }
};
