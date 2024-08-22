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
            $table->date('fecha_ejecucion')->nullable();
            $table->integer('estado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tareas_lotes', function (Blueprint $table) {
            $table->dropColumn('fecha_ejecucion');
            $table->dropColumn('estado');
        });
    }
};
