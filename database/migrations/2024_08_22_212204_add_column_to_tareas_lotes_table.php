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
        Schema::table('tareas_lotes', function (Blueprint $table) {
            $table->integer('cupos');
            $table->float('horas_persona');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tareas_lotes', function (Blueprint $table) {
            $table->dropColumn('cupos');
            $table->dropColumn('horas_persona');
        });
    }
};
