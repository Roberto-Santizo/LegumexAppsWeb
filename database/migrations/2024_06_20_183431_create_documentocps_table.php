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
        Schema::create('documentocps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planta_id')->constrained();
            $table->string('fecha');
            $table->string('observaciones',500)->nullable();
            $table->string('verificado_firma',120)->nullable();
            $table->string('jefemanto_firma',120)->nullable();
            $table->string('supervisor_firma',120)->nullable();
            $table->string('weburl',360)->nullable();
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentocps');
    }
};
