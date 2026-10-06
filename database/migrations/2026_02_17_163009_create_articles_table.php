<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul artikel
            $table->string('slug')->unique(); // URL cantik (contoh: kisah-perang-badar)
            $table->string('thumbnail')->nullable(); // Gambar cover (opsional)
            $table->longText('content'); // Isi artikel lengkap
            $table->string('author')->default('Admin'); // Penulis artikel
            $table->boolean('is_published')->default(true); // Status: Publish atau Draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
