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
        Schema::create('documentolds', function (Blueprint $table) {
            $table->id();
            $table->string('tecnico_mantenimiento',255);
            $table->foreignId('planta_id')->references('id')->on('plantas');
            $table->foreignId('area_id')->references('id')->on('areas');
            $table->string('fecha');
            $table->string('observaciones',500)->nullable();
            $table->boolean('entrada')->nullable();
            $table->string('observaciones_entrada',500)->nullable();
            $table->string('firma_entrada',120)->nullable();
            $table->boolean('salida')->nullable();
            $table->string('observaciones_salida',500)->nullable();
            $table->string('firma_salida',120)->nullable();
            $table->string('tecnico_firma',120)->nullable();
            $table->string('inspector_firma',120)->nullable();
            $table->string('asistente_firma',120)->nullable();
            $table->tinyInteger('estado')->default(0);
            $table->string('weburl',360)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentolds');
    }
};
