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
        Schema::table('orden_trabajos', function (Blueprint $table) {
            // Eliminar columnas
            $table->dropColumn('nombre_jefearea');
            $table->dropColumn('nombre_calidad');
            
            // Agregar llaves foráneas
            $table->foreignId('supervisor_id')->nullable()->constrained('supervisors');
            $table->foreignId('c_calidad_id')->nullable()->constrained('supervisors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_trabajos', function (Blueprint $table) {
            // Eliminar llaves foráneas
            $table->dropForeign(['supervisor_id']);
            $table->dropForeign(['c_calidad_id']);

            // Eliminar columnas de llaves foráneas
            $table->dropColumn('supervisor_id');
            $table->dropColumn('c_calidad_id');

            // Agregar columnas eliminadas
            $table->string('nombre_jefearea',35);
            $table->string('nombre_calidad',35);
        });
    }
};
