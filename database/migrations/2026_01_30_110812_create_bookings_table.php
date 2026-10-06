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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Relasi ke Guru
            $table->foreignId('teacher_profile_id')->constrained()->onDelete('cascade');

            // Data Santri (Simpel dulu, tanpa login)
            $table->string('student_name');
            $table->string('whatsapp');
            $table->date('start_date'); // Tanggal mulai belajar

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
