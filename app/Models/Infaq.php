<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode_bulan',
        'nominal',
        'bukti_transfer',
        'status',
        'catatan_admin',
    ];

    // Relasi: Satu Infaq dimiliki oleh satu User (Santri)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
