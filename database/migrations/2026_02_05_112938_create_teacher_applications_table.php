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
        Schema::create('teacher_applications', function (Blueprint $table) {
            $table->id();
            // Data Pribadi
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('pob'); // Tempat Lahir
            $table->date('dob');   // Tanggal Lahir
            $table->enum('gender', ['L', 'P']);
            $table->enum('marital_status', ['single', 'married']);
            $table->text('address');

            // Pendidikan & Kompetensi
            $table->string('last_education'); // S1/SMA/Ma'had
            $table->string('institution');    // Nama Kampus/Pondok
            $table->string('memorization_juz'); // Jumlah Hafalan
            $table->boolean('has_sanad')->default(false); // Punya Sanad?
            $table->text('sanad_details')->nullable(); // Rincian Sanad
            $table->string('arabic_skill'); // Pemula/Aktif/Pasif

            // File Uploads
            $table->string('cv_path');
            $table->string('photo_path');
            $table->string('certificate_path')->nullable(); // Sertifikat/Ijazah Sanad

            $table->string('status')->default('pending'); // pending, interview, accepted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_applications');
    }
};
