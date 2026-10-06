<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infaqs', function (Blueprint $table) {
            $table->id();
            // ID Santri yang bayar
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Untuk bulan apa infaq ini dibayarkan (contoh: "Februari 2026")
            $table->string('periode_bulan');
            // Nominal infaq (misal: 100000)
            $table->integer('nominal');
            // Lokasi file foto bukti transfer
            $table->string('bukti_transfer');
            // Status: pending, verified, rejected
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            // Catatan admin jika bukti ditolak (buram/salah)
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infaqs');
    }
};
