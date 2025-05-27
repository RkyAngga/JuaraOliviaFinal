<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemerintahPusatDinas extends Model
{
    protected $table = 'pemerintah_pusat_dinas';
    
    protected $fillable = [
        'user_id',
        'dinas_id',
        'latitude',
        'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class);
    }
} 