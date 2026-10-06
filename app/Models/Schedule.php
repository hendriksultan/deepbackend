<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_profile_id',
        'booking_id',
        'title',
        'start',
        'end',
        'status',           // Status Guru (Pending/Completed)
        'student_presence', // Status Santri (Hadir/Sakit/dll)
        'teaching_note',    // Jurnal
        'meeting_link',     // <--- [PENTING] WAJIB DITAMBAHKAN DI SINI
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class, 'teacher_profile_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
