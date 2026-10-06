<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infaqs', function (Blueprint $table) {
            // Mengubah kolom bukti_transfer agar boleh kosong (nullable)
            $table->string('bukti_transfer')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('infaqs', function (Blueprint $table) {
            $table->string('bukti_transfer')->nullable(false)->change();
        });
    }
};
