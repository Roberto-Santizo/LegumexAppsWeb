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
        Schema::create('bitacora_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->references('id')->on('lotes');
            $table->foreignId('cdp_anterior')->references('id')->on('control_plantacions');
            $table->foreignId('cdp_nuevo')->references('id')->on('control_plantacions');
            $table->boolean('estado_anterior');
            $table->boolean('estado_nuevo');
            $table->integer('semana_cambio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_lotes');
    }
};
