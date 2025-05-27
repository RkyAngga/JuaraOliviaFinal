<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'notifikasi_id';
    protected $fillable = [
        'user_id', 'pengaduan_id', 'judul_notifikasi', 'isi_notifikasi',
        'status_notifikasi', 'jenis_notifikasi', 'role_tujuan',
        'alasan_penolakan', 'waktu_tolak'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanPengaduan::class, 'pengaduan_id');
    }
}
