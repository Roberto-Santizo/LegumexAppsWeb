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
        Schema::create('orden_trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planta_id')->nullable()->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->foreignId('elemento_id')->nullable()->constrained();
            $table->string('nombre_solicitante')->nullable();
            $table->string('firma_solicitante')->nullable();
            $table->string('equipo_problema',60)->nullable();
            $table->boolean('retiro_equipo')->nullable();
            $table->string('fecha_propuesta',25)->nullable();
            $table->string('problema_detectado',750)->nullable();
            $table->foreignId('estado_id')->nullable()->constrained();
            $table->string('nombre_jefearea',35)->nullable();
            $table->string('firma_jefearea')->nullable();
            $table->string('trabajo_realizado',750)->nullable();
            $table->string('repuestos_utilizados',750)->nullable();
            $table->foreignId('mecanico_id')->nullable()->constrained('users');
            $table->string('firma_mecanico')->nullable();
            $table->string('jefemanto_nombre',35)->nullable();
            $table->string('jefemanto_firma')->nullable();
            $table->string('fecha_entrega',25)->nullable();
            $table->string('fecha_inspeccion',25)->nullable();
            $table->string('hora_inicio')->nullable();
            $table->string('hora_final')->nullable();
            $table->string('especifique',60)->nullable();
            $table->integer('urgencia')->nullable();
            $table->timestamp('fecha_asignacion')->nullable();

            $table->boolean('devolucion_equipo')->nullable();
            $table->boolean('limpieza_equipo')->nullable();
            $table->boolean('orden_area')->nullable();
            $table->boolean('liberacion_trabajo')->nullable();
            $table->string('nombre_calidad',35)->nullable();
            $table->string('fecha_inspeccion_calidad')->nullable();
            $table->string('firma_calidad')->nullable();
            $table->boolean('rechazada')->nullable();
            $table->string('weburl',360)->nullable();
            
            
            $table->string('observaciones_eliminacion',520)->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_trabajos');
    }
};
