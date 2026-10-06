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
            $table->string('birth_place')->nullable()->after('phone'); // Tempat Lahir
            $table->date('birth_date')->nullable()->after('birth_place'); // Tanggal Lahir
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date'); // L = Laki-laki, P = Perempuan
            $table->text('address')->nullable()->after('gender'); // Alamat Lengkap
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birth_place', 'birth_date', 'gender', 'address']);
        });
    }
};
