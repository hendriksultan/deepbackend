<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =================================================================
    // KODE SAKTI: Otomatis Menghitung Total Donasi Setiap Ada Perubahan
    // =================================================================
    protected static function booted()
    {
        // Berjalan saat donasi baru dibuat atau diupdate statusnya
        static::saved(function ($donation) {
            $total = $donation->campaign->donations()->where('status', 'paid')->sum('amount');
            $donation->campaign->update(['collected_amount' => $total]);
        });

        // Berjalan jika ada data donasi yang dihapus oleh Admin
        static::deleted(function ($donation) {
            $total = $donation->campaign->donations()->where('status', 'paid')->sum('amount');
            $donation->campaign->update(['collected_amount' => $total]);
        });
    }
}