<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_mukafaahs', function (Blueprint $table) {
            // Kita pakai string biasa karena menginduk ke kolom 'group_name' di tabel bookings
            $table->string('group_name')->nullable()->after('teacher_profile_id');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_mukafaahs', function (Blueprint $table) {
            $table->dropColumn('group_name');
        });
    }
};