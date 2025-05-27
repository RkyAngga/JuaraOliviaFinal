<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'wilayah',
        'latitude',
        'longitude',
        'grade',
        'point'
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemerintahPusat()
    {
        return $this->belongsToMany(User::class, 'pemerintah_pusat_dinas', 'dinas_id', 'user_id')
            ->withTimestamps();
    }
}
