<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_verified',
        'phone',
        'profile_photo_path',

        // [BARU] Tambahan Biodata Lengkap
        'birth_place', // Tempat Lahir
        'birth_date',  // Tanggal Lahir
        'gender',      // Jenis Kelamin (L/P)
        'address',     // Alamat Lengkap
        
        // [TAMBAHAN TERBARU] Kolom Wilayah untuk Filter Pencarian
        'province', 
        'city',  
        'district', // Tambahan baru (Kecamatan)
        'village',  // Tambahan baru (Desa/Kelurahan)
        
        'student_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',

        // [BARU] Casting agar Tanggal Lahir otomatis jadi object Carbon (Date)
        'birth_date' => 'date',
    ];

    // --- HELPER UNTUK CEK ROLE ---
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }
    public function isStudent()
    {
        return $this->role === 'student';
    }

    // --- FUNGSI KEAMANAN FILAMENT ---
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'teacher') {
            return $this->isTeacher();
        }

        return false;
    }

    // =========================================================
    // FUNGSI UNTUK MEMUNCULKAN AVATAR DI POJOK KANAN
    // =========================================================
    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->profile_photo_path) {
            return Storage::url($this->profile_photo_path);
        }

        return null;
    }

    // --- RELASI ---
    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // =========================================================
    // [BARU] RELASI UNTUK FITUR MATERI "TELAH DIPELAJARI"
    // =========================================================
    public function completedMaterials()
    {
        return $this->belongsToMany(\App\Models\StudyMaterial::class, 'study_material_user')->withTimestamps();
    }
}