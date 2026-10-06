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
        Schema::create('arabic_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('topik_materi'); // Judul materi yang dipelajari (misal: Perkenalan, Isim Isyaroh)

            // Metrik Penilaian (Bisa disesuaikan, misal pakai A, B, C, D atau Mumtaz, Jayyid)
            $table->string('nilai_kosakata')->nullable(); // Mufradat
            $table->string('nilai_tata_bahasa')->nullable(); // Nahwu/Shorof
            $table->string('nilai_percakapan')->nullable(); // Muhadatsah/Kalam

            $table->text('catatan_guru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arabic_evaluations');
    }
};
