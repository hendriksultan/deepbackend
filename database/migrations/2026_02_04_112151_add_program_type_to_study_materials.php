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
        Schema::table('study_materials', function (Blueprint $table) {
            // Kita tambah kolom enum: all (umum), online, offline
            $table->enum('program_type', ['all', 'online', 'offline'])
                ->default('all')
                ->after('description')
                ->comment('Menentukan target audiens materi');
        });
    }

    public function down(): void
    {
        Schema::table('study_materials', function (Blueprint $table) {
            $table->dropColumn('program_type');
        });
    }
};
