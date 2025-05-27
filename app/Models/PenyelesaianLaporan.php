<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyelesaianLaporan extends Model
{
    protected $table = 'penyelesaian_laporan';
    protected $primaryKey = 'penyelesaian_laporan_id';
    protected $fillable = [
        'pengaduan_id', 'dinas_id', 'status', 'alasan_penolakan', 'waktu_tolak',
        'tanggal_mulai', 'tanggal_selesai', 'foto_penyelesaian', 'deskripsi_pengerjaan', 'waktu_foto', 'alamat_foto'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanPengaduan::class, 'pengaduan_id');
    }
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }
}
