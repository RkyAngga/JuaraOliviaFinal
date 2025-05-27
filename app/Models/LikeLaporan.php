<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeLaporan extends Model
{
    protected $table = 'like_laporan';
    protected $primaryKey = 'like_id';
    protected $fillable = ['pengaduan_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function pengaduan() {
        return $this->belongsTo(LaporanPengaduan::class, 'pengaduan_id', 'id');
    }
} 