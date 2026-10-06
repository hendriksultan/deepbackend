<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'file_path',
        'status',
        'score',
        'teacher_notes',
    ];

    // Relasi balik ke Tugas
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke Santri (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
