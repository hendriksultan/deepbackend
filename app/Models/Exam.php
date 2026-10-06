<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];

    // Relasi ke Guru
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    // Relasi ke Soal (Satu ujian punya banyak soal)
    // Diperbarui dengan orderBy agar mengikuti urutan Drag & Drop
    public function questions()
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('sort');
    }

    // Relasi ke Nilai (Satu ujian dikerjakan banyak siswa)
    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
