<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiIqra extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'tanggal',
        'jilid',
        'halaman',
        'nilai',
        'catatan_guru',
    ];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
