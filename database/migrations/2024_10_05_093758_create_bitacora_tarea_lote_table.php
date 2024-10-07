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
        Schema::create('bitacora_tarea_lote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_lote_id')->constrained('tareas_lotes','id');
            $table->foreignId('plan_semanal_id_dest')->constrained('plan_semanal_fincas','id');
            $table->foreignId('plan_semanal_id_org')->constrained('plan_semanal_fincas','id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_tarea_lote');
    }
};
