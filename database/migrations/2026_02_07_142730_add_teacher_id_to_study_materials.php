<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('study_materials', function (Blueprint $table) {
            // Relasi ke tabel teacher_profiles, nullable (boleh kosong untuk materi umum)
            $table->foreignId('teacher_profile_id')
                ->nullable()
                ->after('program_type')
                ->constrained('teacher_profiles')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('study_materials', function (Blueprint $table) {
            $table->dropForeign(['teacher_profile_id']);
            $table->dropColumn('teacher_profile_id');
        });
    }
};
