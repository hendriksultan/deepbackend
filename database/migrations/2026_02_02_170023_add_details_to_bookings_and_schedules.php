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
        // 1. Simpan Alamat di Booking (Khusus Offline)
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('method')->default('online')->after('program_type'); // 'online' atau 'offline'
            $table->text('student_address')->nullable()->after('method'); // Alamat rumah siswa
            $table->string('maps_link')->nullable()->after('student_address'); // Link Google Maps (Opsional)
        });

        // 2. Simpan Link Zoom di Schedule (Khusus Online)
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('meeting_link')->nullable()->after('status'); // Link Zoom/Gmeet
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings_and_schedules', function (Blueprint $table) {
            //
        });
    }
};
