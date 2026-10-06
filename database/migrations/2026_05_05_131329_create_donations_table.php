<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            
            // Relasi ke tabel users (jika donatur sedang login)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); 
            
            // Data profil donatur (jika tamu/guest)
            $table->string('donor_name');
            $table->string('donor_phone')->nullable();
            $table->string('donor_email')->nullable();
            
            $table->unsignedBigInteger('amount'); // Nominal transfer
            
            // Sistem Pembayaran
            $table->string('payment_method'); // Contoh: 'manual' atau 'tripay'
            $table->string('payment_channel')->nullable(); // Contoh: 'BSI', 'QRIS', 'BCAVA'
            $table->string('reference')->unique(); // Kode Invoice / Referensi Tripay
            $table->string('status')->default('pending'); // pending, paid, failed, expired
            
            // Bukti transfer manual & Catatan
            $table->string('proof_of_payment')->nullable(); 
            $table->text('message')->nullable(); // Doa atau pesan dari donatur
            $table->boolean('is_anonymous')->default(false); // Hamba Allah
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};