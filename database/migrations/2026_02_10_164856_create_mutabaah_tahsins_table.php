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
        Schema::create('mutabaah_tahsins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->date('tanggal');

            // Materi Tahsin
            $table->string('jilid'); // Contoh: Jilid 1, Jilid 2, atau Al-Quran
            $table->string('halaman')->nullable(); // Halaman buku/iqra
            $table->string('surah')->nullable(); // Jika sudah Al-Quran
            $table->string('ayat')->nullable(); // Jika sudah Al-Quran

            // Penilaian
            $table->string('nilai'); // A, B, C atau Mumtaz, Jayyid, dll
            $table->text('catatan_tajwid')->nullable(); // Catatan khusus kesalahan tajwid
            $table->text('catatan_guru')->nullable(); // Motivasi atau PR

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutabaah_tahsins');
    }
};
