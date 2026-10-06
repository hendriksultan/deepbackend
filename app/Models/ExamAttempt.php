<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $guarded = [];

    // === TAMBAHKAN BAGIAN INI (PENTING!) ===
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'score' => 'integer', // Opsional: Memastikan nilai selalu angka
        'answers' => 'array',
    ];
    // =======================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
