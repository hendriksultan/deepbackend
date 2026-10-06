<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // PENTING: Izinkan semua kolom agar Controller bisa menyimpan data
    protected $guarded = [];

    // =========================================================
    // [BARU] Tambahkan ini agar kolom is_free dibaca sebagai boolean
    // =========================================================
    protected $casts = [
        'is_free' => 'boolean',
        'latitude'  => 'float', // <-- Tambahan baru
        'longitude' => 'float', // <-- Tambahan baru
    ];

    // Relasi ke Guru
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}