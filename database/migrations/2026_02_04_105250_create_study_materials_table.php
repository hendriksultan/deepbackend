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
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Materi
            $table->text('description')->nullable(); // Deskripsi Singkat
            $table->enum('type', ['video', 'document']); // Jenis Materi
            $table->string('file_path')->nullable(); // Untuk upload PDF
            $table->string('video_url')->nullable(); // Untuk link Youtube/Zoom
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
