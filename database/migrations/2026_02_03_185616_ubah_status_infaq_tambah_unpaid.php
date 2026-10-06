<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom ENUM dengan SQL mentah agar aman dan didukung semua database
        DB::statement("ALTER TABLE infaqs MODIFY COLUMN status ENUM('unpaid', 'pending', 'verified', 'rejected') DEFAULT 'unpaid'");
    }

    public function down(): void
    {
        // Mengembalikan ke kondisi semula jika di-rollback
        DB::statement("ALTER TABLE infaqs MODIFY COLUMN status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending'");
    }
};
