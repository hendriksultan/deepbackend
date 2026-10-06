<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranBookmark extends Model
{
    protected $fillable = ['user_id', 'surat_nomor', 'ayat_nomor'];
}
