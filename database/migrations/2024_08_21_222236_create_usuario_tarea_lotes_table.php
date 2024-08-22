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
        Schema::create('usuario_tarea_lotes', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_id');
            $table->foreignId('tarealote_id')->references('id')->on('tareas_lotes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_tarea_lotes');
    }
};
