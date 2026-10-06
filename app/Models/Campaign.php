<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Relasi: 1 Campaign memiliki banyak Donation
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}