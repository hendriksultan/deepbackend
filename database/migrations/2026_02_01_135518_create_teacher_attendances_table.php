<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
            // Terhubung ke Teacher Profile (bukan user_id langsung, biar konsisten)
            $table->foreignId('teacher_profile_id')->constrained('teacher_profiles')->onDelete('cascade');

            $table->date('date'); // Tanggal Absen
            $table->time('clock_in')->nullable();  // Jam Masuk
            $table->time('clock_out')->nullable(); // Jam Pulang
            $table->string('status')->default('present'); // present, sick, permit
            $table->text('note')->nullable(); // Catatan harian (opsional)

            // Lokasi (Opsional, buat jaga-jaga kalau butuh koordinat)
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
    }
};
