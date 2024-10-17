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
        Schema::create('cierre_tarea_lote_cosecha_semanals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_lote_cosecha_id')->references('id')->on('tarea_lote_cosechas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_tarea_lote_cosecha_semanals');
    }
};
