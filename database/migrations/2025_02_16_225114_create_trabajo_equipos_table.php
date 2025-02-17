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
        Schema::create('trabajo_equipos', function (Blueprint $table) {
            $table->id();
            $table->string('responsable')->nullable();
            $table->foreignId('equipo_id')->constrained();
            $table->datetime('fecha_planificacion');
            $table->datetime('fecha_realizacion')->nullable();
            $table->string('descripcion');
            $table->string('firma_responsable')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajo_equipos');
    }
};
