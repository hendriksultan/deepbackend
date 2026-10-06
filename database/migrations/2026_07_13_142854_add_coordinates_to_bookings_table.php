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
            // Menambahkan kolom latitude dan longitude
            // Tipe decimal(10, 8) dan (11, 8) adalah standar presisi yang akurat untuk Google Maps/Leaflet
            $table->decimal('latitude', 10, 8)->nullable()->after('student_address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
