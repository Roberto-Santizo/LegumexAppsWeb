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
        Schema::create('tarea_cosechas', function (Blueprint $table) {
            $table->id();
            $table->string('tarea');
            $table->string('descripcion',355);
            $table->string('code',355);
            $table->foreignId('cultivo_id')->constrained()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_cosechas');
    }
};
