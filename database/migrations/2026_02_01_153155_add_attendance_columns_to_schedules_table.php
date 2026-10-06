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
        Schema::table('schedules', function (Blueprint $table) {
            // Status jadwal: pending (belum), completed (sudah)
            $table->string('status')->default('pending')->after('end');

            // Kehadiran Santri: present, sick, permit, alpha
            $table->string('student_presence')->nullable()->after('status');

            // Catatan Guru (Jurnal Mengajar)
            $table->text('teaching_note')->nullable()->after('student_presence');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['status', 'student_presence', 'teaching_note']);
        });
    }
};
