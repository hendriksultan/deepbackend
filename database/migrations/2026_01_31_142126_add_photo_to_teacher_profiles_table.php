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
        Schema::table('teacher_profiles', function (Blueprint $table) {
            // Cek dulu apakah kolom 'photo' sudah ada biar tidak error jika dijalankan ulang
            if (!Schema::hasColumn('teacher_profiles', 'photo')) {
                $table->string('photo')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('teacher_profiles', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
