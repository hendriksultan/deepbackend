<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambahkan kolom program_type jika belum ada
            if (!Schema::hasColumn('bookings', 'program_type')) {
                $table->string('program_type')->nullable()->after('whatsapp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'program_type')) {
                $table->dropColumn('program_type');
            }
        });
    }
};
