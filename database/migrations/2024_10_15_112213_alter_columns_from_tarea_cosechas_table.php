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
        Schema::table('tarea_lote_cosechas', function (Blueprint $table) {
            // Eliminar la clave foránea existente y la columna
            $table->dropForeign('tarea_lote_cosechas_tarea_id_foreign');
            $table->dropColumn('tarea_id');

            // Agregar la nueva columna y la clave foránea
            $table->foreignId('tarea_cosecha_id')->constrained('tarea_cosechas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarea_lote_cosechas', function (Blueprint $table) {
            // Eliminar la nueva clave foránea y la columna
            $table->dropForeign('tarea_lote_cosechas_tarea_cosecha_id_foreign');
            $table->dropColumn('tarea_cosecha_id');

            // Restaurar la columna original y la clave foránea
            $table->foreignId('tarea_id')->constrained('tareas')->onDelete('cascade');
        });
    }
};
