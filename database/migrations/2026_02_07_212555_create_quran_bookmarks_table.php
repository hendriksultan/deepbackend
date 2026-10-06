<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quran_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('surat_nomor'); // Cth: 18 (Al-Kahfi)
            $table->integer('ayat_nomor');  // Cth: 10
            $table->timestamps();

            // Opsional: Agar 1 user hanya bisa bookmark 1 ayat spesifik sekali saja (mencegah duplikat)
            $table->unique(['user_id', 'surat_nomor', 'ayat_nomor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_bookmarks');
    }
};
