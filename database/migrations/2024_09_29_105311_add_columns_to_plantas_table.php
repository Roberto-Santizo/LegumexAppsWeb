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
        Schema::table('plantas', function (Blueprint $table) {
            $table->string('documetold_folder_id');
            $table->string('checklist_folder_id');
            $table->string('ot_folder_id');
            $table->string('prefix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantas', function (Blueprint $table) {
            $table->dropColumn('documetold_folder_id');
            $table->dropColumn('checklist_folder_id');
            $table->dropColumn('ot_folder_id');
            $table->dropColumn('prefix');
        });
    }
};
