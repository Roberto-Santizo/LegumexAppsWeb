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
        Schema::create('control_plantacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('semana');
            $table->foreignId('cultivo_id')->references('id')->on('cultivos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_plantacions');
    }
};
