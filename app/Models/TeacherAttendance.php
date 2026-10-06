<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_profile_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'note',
        'latitude',
        'longitude',
        'proof_file',
    ];

    // Relasi ke Guru
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }
}
