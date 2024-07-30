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
        Schema::create('herramientas_documentolds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documentold_id')->constrained()->onDelete('cascade');
            $table->foreignId('herramienta_id')->constrained();
            $table->boolean('desinfectada_entrada')->nullable();
            $table->boolean('lavada_entrada')->nullable();
            $table->boolean('desinfectada_salida')->nullable();
            $table->boolean('lavada_salida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herramientas_documentolds');
    }
};
