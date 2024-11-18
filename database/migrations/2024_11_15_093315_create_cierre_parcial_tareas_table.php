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
        Schema::create('cierre_parcial_tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarealote_id')->constrained()->on('tareas_lotes');
            $table->datetime('fecha_inicio')->nullable();
            $table->datetime('fecha_final')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_parcial_tareas');
    }
};
