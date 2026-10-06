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
        Schema::table('exam_attempts', function (Blueprint $table) {
            // Menambahkan kolom untuk mencatat waktu mulai & selesai
            $table->timestamp('started_at')->nullable()->after('exam_id');
            $table->timestamp('finished_at')->nullable()->after('score');

            // Opsional: Ubah kolom score agar bisa NULL (karena saat mulai, nilai belum ada)
            $table->integer('score')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'finished_at']);
            // Kembalikan score jadi tidak null (jika perlu rollback)
            $table->integer('score')->default(0)->change();
        });
    }
};
