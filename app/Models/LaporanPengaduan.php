<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPengaduan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengaduan';

    protected $fillable = [
        'masyarakat_id',
        'dinas_id',
        'lokasi',
        'latitude',
        'longitude',
        'foto_video',
        'deskripsi',
        'status',
        'timestamp',
        'related_pengaduan_id',
        'escalated_to_pusat',
        'waktu_menunggu_expired',
    ];

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }

    public function tracking()
    {
        return $this->hasMany(\App\Models\TrackingLaporan::class, 'pengaduan_id');
    }

    public function related()
    {
        return $this->hasMany(LaporanPengaduan::class, 'related_pengaduan_id');
    }

    public function penyelesaian()
    {
        return $this->hasOne(\App\Models\PenyelesaianLaporan::class, 'pengaduan_id');
    }

    public function ulasan()
    {
        return $this->hasOne(\App\Models\UlasanLaporan::class, 'laporan_id');
    }
}
