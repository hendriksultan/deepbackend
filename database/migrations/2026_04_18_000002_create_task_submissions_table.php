<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            // Relasi ke Tugas dan Santri
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('file_path'); // File tugas yang dikumpulkan santri
            $table->string('status')->default('pending'); // pending, graded
            $table->string('score')->nullable(); // Nilai dari guru
            $table->text('teacher_notes')->nullable(); // Catatan revisi/evaluasi

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
