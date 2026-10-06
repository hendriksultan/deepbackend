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
        Schema::create('mutabaahs', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel bookings (karena di sana ada data santri & guru)
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');

            $table->date('tanggal');
            $table->string('jenis_setoran'); // Ziyadah / Murajaah / Tahsin
            $table->string('surah');
            $table->integer('ayat_awal')->nullable();
            $table->integer('ayat_akhir')->nullable();
            $table->string('nilai'); // Mumtaz, Jayyid, dll
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutabaahs');
    }
};
