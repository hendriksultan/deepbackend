<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherMukafaah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }
}