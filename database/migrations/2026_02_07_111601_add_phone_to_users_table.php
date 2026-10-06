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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom phone setelah email, set nullable (boleh kosong)
            $table->string('phone')->nullable()->after('email');

            // JAGA-JAGA: Jika kolom profile_photo_path juga belum ada, tambahkan baris ini:
            // $table->string('profile_photo_path', 2048)->nullable()->after('phone');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            // $table->dropColumn('profile_photo_path'); // Hapus komentar ini jika tadi menambahkan foto
        });
    }
};
