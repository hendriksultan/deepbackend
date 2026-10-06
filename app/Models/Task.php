<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_profile_id',
        'group_name',
        'title',
        'description',
        'file_path',
        'deadline',
        
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relasi ke Guru
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    // Relasi ke tabel pengumpulan tugas
    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
