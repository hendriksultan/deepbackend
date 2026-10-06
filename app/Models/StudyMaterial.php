<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;

    // App\Models\StudyMaterial.php

    protected $fillable = [
        'title',
        'description',
        'program_type',
        'type',
        'video_url',
        'file_path',
        'is_active',
        'teacher_profile_id', // <--- Tambahkan ini
        'group_name',
    ];

    // Relasi ke Guru
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    // =========================================================
    // [BARU] RELASI UNTUK FITUR MATERI "TELAH DIPELAJARI"
    // =========================================================
    public function completedByUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'study_material_user')->withTimestamps();
    }
}