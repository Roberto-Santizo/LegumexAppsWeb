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
        Schema::create('areas_c_p_elementos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documentocp_area')->constrained('areas_checklist_p_s','id');
            $table->foreignId('elemento_id')->constrained('elementos','id');
            $table->boolean('ok')->nullable();
            $table->string('problema',29)->nullable();
            $table->string('accion',29)->nullable();
            $table->foreignId('orden_trabajos_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas_c_p_elementos');
    }
};
