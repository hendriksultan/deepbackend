<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class ExamQuestion extends Model
{
    // Tetap gunakan ini, aman dan praktis
    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer', // Opsional: memastikan poin selalu angka
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // ==========================================
    // TAMBAHAN HELPER (SANGAT BERGUNA)
    // ==========================================

    /**
     * Helper untuk mengambil URL Gambar
     * Cara pakai di Blade: <img src="{{ $question->image_url }}" />
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Helper untuk mengambil URL Audio
     * Cara pakai di Blade: <audio src="{{ $question->audio_url }}"></audio>
     */
    public function getAudioUrlAttribute()
    {
        return $this->audio ? asset('storage/' . $this->audio) : null;
    }

    /**
     * Cek apakah soal ini Pilihan Ganda
     */
    public function getIsMultipleChoiceAttribute()
    {
        return $this->type === 'multiple_choice';
    }

    /**
     * Cek apakah soal ini Essay
     */
    public function getIsEssayAttribute()
    {
        return $this->type === 'essay';
    }
}
