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
        Schema::create('evaluasi_iqras', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel booking
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();

            $table->date('tanggal');

            // Evaluasi spesifik Iqra
            $table->enum('jilid', ['1', '2', '3', '4', '5', '6']);
            $table->integer('halaman');
            $table->enum('nilai', ['A', 'B', 'C', 'D']);

            $table->text('catatan_guru')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_iqras');
    }
};
