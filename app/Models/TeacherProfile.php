<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeacherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'specialization',
        'method',
        'is_verified',
        'photo',
        'student_quota',
        'teaching_levels', // [BARU] Tambahkan ini agar bisa disimpan
        'bank_account',    // [BARU] Menambahkan field nomor rekening agar bisa disimpan ke database
        'is_contract_signed',
        'signature_name',
    ];

    // [BARU] Wajib ditambahkan agar multiple select tersimpan sebagai array/json
    protected $casts = [
        'teaching_levels' => 'array',
    ];

    // --- RELASI ---

    // Relasi ke User (Data Akun)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jadwal (Schedule)
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Relasi ke Booking/Pendaftaran Santri
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // =================================================================
    // [BARU] Relasi ke Tugas (Task)
    // =================================================================
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // --- AKSESOR & ATRIBUT ---

    // Hitung Sisa Kuota Otomatis
    public function getRemainingQuotaAttribute()
    {
        // Rumus: Kuota Guru - Jumlah Santri yang sudah booking
        return $this->student_quota - $this->bookings()->count();
    }

    // Cek Status Penuh (True/False)
    public function getIsFullAttribute()
    {
        return $this->remaining_quota <= 0;
    }

    // Aksesor Foto Pintar (Fallback ke User)
    public function getPhotoUrlAttribute()
    {
        // 1. Prioritas Utama: Cek foto khusus di profil guru (tabel teacher_profiles)
        if ($this->photo) {
            return Storage::url($this->photo);
        }

        // 2. Fallback: Jika kosong, cek foto di akun User (tabel users)
        // Kita akses via relasi $this->user
        if ($this->user && $this->user->profile_photo_path) {
            return Storage::url($this->user->profile_photo_path);
        }

        // 3. Jika keduanya kosong, kembalikan null
        return null;
    }
}