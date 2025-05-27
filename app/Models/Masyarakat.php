<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $fillable = [
        'user_id',
        'username',
        'role',
        'masyarakat_id',
        'foto_profil',
        'poin',
        'last_report_at'
    ];

    protected $casts = [
        'last_report_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporanPengaduan()
    {
        return $this->hasMany(LaporanPengaduan::class, 'masyarakat_id');
    }
} 