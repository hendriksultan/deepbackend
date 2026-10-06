<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus kolom start_date karena sudah tidak dipakai
            if (Schema::hasColumn('bookings', 'start_date')) {
                $table->dropColumn('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kembalikan jika rollback
            $table->date('start_date')->nullable();
        });
    }
};
