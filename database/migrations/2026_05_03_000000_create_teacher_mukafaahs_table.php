<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_mukafaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_profile_id')->constrained('teacher_profiles')->cascadeOnDelete();
            $table->string('month'); 
            $table->string('year');  
            
            $table->integer('total_attendance')->default(0); 
            $table->integer('total_schedule')->default(4); // Default 4 pertemuan sebulan
            
            $table->decimal('base_amount', 12, 2)->default(0); // 60% x Infaq
            $table->decimal('adjustment_amount', 12, 2)->default(0); // Plus/Minus manual
            $table->string('adjustment_reason')->nullable();
            $table->decimal('final_amount', 12, 2)->default(0);
            
            $table->string('payment_status')->default('Belum Dibayar'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_mukafaahs');
    }
};