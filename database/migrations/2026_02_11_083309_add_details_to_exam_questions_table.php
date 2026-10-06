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
        Schema::table('exam_questions', function (Blueprint $table) {
            // 1. Menambahkan kolom 'type' setelah 'exam_id'
            // Kita set default 'multiple_choice' agar data lama tidak error (semua data lama dianggap PG)
            $table->enum('type', ['multiple_choice', 'true_false', 'essay'])
                ->default('multiple_choice')
                ->after('exam_id');

            // 2. Menambahkan kolom media (image & audio) setelah 'question'
            $table->string('image')->nullable()->after('question');
            $table->string('audio')->nullable()->after('image');

            // 3. Menambahkan kolom penjelasan setelah kunci jawaban
            $table->text('explanation')->nullable()->after('points');

            // 4. MENGUBAH kolom lama (options & correct_answer)
            // 'options' jadi nullable (karena esai tidak punya opsi)
            $table->json('options')->nullable()->change();

            // 'correct_answer' jadi text (agar muat jawaban esai panjang) & nullable
            $table->text('correct_answer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_questions', function (Blueprint $table) {
            // Hapus kolom baru jika di-rollback
            $table->dropColumn(['type', 'image', 'audio', 'explanation']);

            // Kembalikan kolom lama ke kondisi semula (Opsional)
            // Hati-hati: mengubah text ke string bisa memotong data jika ada jawaban esai panjang
            $table->json('options')->nullable(false)->change();
            $table->string('correct_answer')->change();
        });
    }
};
