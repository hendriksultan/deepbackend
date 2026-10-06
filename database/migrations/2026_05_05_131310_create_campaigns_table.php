<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Untuk banner donasi
            $table->unsignedBigInteger('target_amount')->nullable(); // Target nominal (Rupiah)
            $table->unsignedBigInteger('collected_amount')->default(0); // Dana terkumpul
            $table->date('end_date')->nullable(); // Batas waktu (jika ada)
            $table->boolean('is_active')->default(true); // Status buka/tutup
            $table->timestamps();
            $table->softDeletes(); // Fitur hapus sementara
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};