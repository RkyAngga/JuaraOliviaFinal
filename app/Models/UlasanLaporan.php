<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanLaporan extends Model
{
    protected $table = 'ulasan_laporan';
    protected $fillable = ['laporan_id', 'masyarakat_id', 'rating', 'ulasan'];

    public function laporan()
    {
        return $this->belongsTo(LaporanPengaduan::class, 'laporan_id');
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'masyarakat_id');
    }
}
