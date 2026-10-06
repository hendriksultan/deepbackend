<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutabaah extends Model
{
  use HasFactory;

  // Izinkan semua kolom diisi
  protected $guarded = [];

  // Relasi ke Booking
  public function booking()
  {
    return $this->belongsTo(Booking::class);
  }
}
