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
        Schema::table('bookings', function (Blueprint $table) {
            // Cek dulu: Jika kolom 'status' BELUM ada, baru buat.
            // (Ini menjaga agar data status Admin yang lama AMAN)
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending');
            }

            // Cek dulu: Jika kolom 'payment_proof' BELUM ada, baru buat.
            if (!Schema::hasColumn('bookings', 'payment_proof')) {
                $table->string('payment_proof')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus payment_proof jika rollback
            if (Schema::hasColumn('bookings', 'payment_proof')) {
                $table->dropColumn(['payment_proof']);
            }

            // Opsional: Hapus status jika rollback (hati-hati)
            // $table->dropColumn(['status']); 
        });
    }
};
