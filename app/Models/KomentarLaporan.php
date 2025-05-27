<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarLaporan extends Model
{
    protected $table = 'komentar_laporan';
    protected $primaryKey = 'komentar_id';
    protected $fillable = ['pengaduan_id', 'user_id', 'isi_komentar'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function pengaduan() {
        return $this->belongsTo(LaporanPengaduan::class, 'pengaduan_id', 'id');
    }
} 