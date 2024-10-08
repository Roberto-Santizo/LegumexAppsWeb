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
        Schema::create('tarea_lote_cosechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_semanal_finca_id')->references('id')->on('plan_semanal_fincas');
            $table->foreignId('lote_id')->references('id')->on('lotes');
            $table->foreignId('tarea_id')->references('id')->on('tareas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_lote_cosechas');
    }
};
