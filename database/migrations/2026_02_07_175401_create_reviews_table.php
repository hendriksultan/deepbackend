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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Pengulas
            $table->string('role')->nullable(); // Cth: Santri, Wali Santri, Mahasiswa
            $table->text('content'); // Isi ulasan
            $table->integer('rating')->default(5); // Bintang 1-5
            $table->boolean('is_visible')->default(false); // Moderasi: Admin harus setujui dulu baru tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
