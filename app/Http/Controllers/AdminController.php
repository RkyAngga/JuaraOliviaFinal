<?php

namespace App\Http\Controllers;

use App\Models\LaporanPengaduan;
use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLaporan = \App\Models\LaporanPengaduan::count();
        $laporanDiproses = \App\Models\LaporanPengaduan::where('status', 'Di Proses')->count();
        $laporanSelesai = \App\Models\LaporanPengaduan::where('status', 'Selesai')->count();
        $laporanDitolak = \App\Models\LaporanPengaduan::where('status', 'Ditolak')->count();

        $dinasList = \App\Models\Dinas::all();

        // Statistik per kecamatan (opsional, jika ingin tetap ada)
        $kecamatanStats = collect(); // Kosongkan jika tidak dipakai

        return view('Dashboardstlhlogin.Admin.Dashboard', compact(
            'totalLaporan',
            'laporanDiproses',
            'laporanSelesai',
            'laporanDitolak',
            'dinasList',
            'kecamatanStats'
        ));
    }
} 