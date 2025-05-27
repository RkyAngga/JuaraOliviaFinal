<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingLaporan extends Model
{
    protected $table = 'tracking_laporan';
    protected $fillable = [
        'pengaduan_id', 'status', 'sub_status', 'keterangan', 'escalated_to_pusat'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanPengaduan::class, 'pengaduan_id');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'id_admin');
    }
}
