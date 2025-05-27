<?php

// app/Http/Controllers/LaporanPengaduanController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPengaduan;
use Illuminate\Support\Facades\Auth;
use App\Models\Dinas;
use App\Models\TrackingLaporan;
use App\Models\PenyelesaianLaporan;
use App\Models\Admin;
use App\Models\UlasanLaporan;
use App\Models\Notifikasi;
use App\Models\PemerintahPusatDinas;
use App\Models\PesanPusatKeDinas;
use App\Models\KomentarLaporan;
use App\Models\LikeLaporan;

class LaporanPengaduanController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Masuk ke store laporan', ['user_id' => Auth::id()]);
        \Log::info('Request all', $request->all());
        \Log::info('Request files', $request->allFiles());

        $masyarakat = Auth::user()->masyarakat;
        $masyarakatId = $masyarakat->id ?? null;
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Check for exact duplicate report by the same user at the same location within the last 5 seconds
        $exactDuplicate = \App\Models\LaporanPengaduan::where('masyarakat_id', $masyarakatId)
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->where('created_at', '>=', now()->subSeconds(5))
            ->exists();

        if ($exactDuplicate) {
            return; // Stop execution silently
        }

        // Check for recent duplicate reports within 10 meters and last 15 seconds for the same user
        $recentNearbyReport = \App\Models\LaporanPengaduan::selectRaw('*, (6371000 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '<=', 10) // Check within 10 meters radius
            ->where('masyarakat_id', $masyarakatId)
            ->whereIn('status', ['Menunggu', 'Di Proses']) // Consider pending reports
            ->where('created_at', '>=', now()->subSeconds(15)) // Check within last 15 seconds
            ->exists();

        if ($recentNearbyReport) {
            return; // Stop execution silently
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // max 5MB
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
        ]);
        \Log::info('Validation passed');

        $masyarakat = Auth::user()->masyarakat;
        $masyarakatId = $masyarakat->id ?? null;
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // 3. CARI LAPORAN UTAMA (pertama) di radius 5 meter
        $laporanUtama = \App\Models\LaporanPengaduan::selectRaw('*, (6371000 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [$latitude, $longitude, $latitude])
            ->having('distance', '<=', 5)
            ->orderBy('created_at', 'asc')
            ->first();

        $relatedId = $laporanUtama ? $laporanUtama->id : null;

        // 4. SIMPAN LAPORAN BARU
        $path = $request->file('foto')->store('laporan', 'public');

        // Atur dinas_id secara eksplisit menjadi 1 karena hanya ada 1 dinas
        // Hapus atau perbaiki logika penentuan dinas berdasarkan lokasi di masa depan jika ada lebih dari 1 dinas.
        $assignedDinasId = 1;
        \Log::info('Menetapkan dinas_id = 1 untuk laporan baru');

        $laporan = \App\Models\LaporanPengaduan::create([
            'masyarakat_id' => $masyarakatId,
            'dinas_id' => $assignedDinasId, // Gunakan assignedDinasId (sekarang 1)
            'lokasi' => $request->input('alamat'),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'foto_video' => $path,
            'deskripsi' => $request->input('deskripsi'),
            'status' => 'Menunggu',
            'related_pengaduan_id' => $relatedId,
            'escalated_to_pusat' => false,
            'waktu_menunggu_expired' => now()->addMinutes(2),
        ]);

        if ($laporan) {
            // 5. UPDATE COOLDOWN DAN TAMBAH POIN
            // Ambil kembali model masyarakat untuk memastikan data terbaru
            $masyarakat = $laporan->masyarakat; // Ambil relasi masyarakat dari laporan yang baru dibuat

            // Setel waktu laporan terakhir dan tambahkan poin
            $masyarakat->last_report_at = now();
            $masyarakat->poin += 10; // Tambahkan poin (Pastikan ini sesuai dengan logika bisnis Anda)

            // Simpan perubahan pada model masyarakat
            $masyarakat->save();

            \Log::info('Masyarakat mendapat 10 poin dari laporan baru', ['user_id' => $masyarakat->user_id, 'current_poin' => $masyarakat->poin]);
            \Log::info('Laporan berhasil disimpan dan cooldown diperbarui', ['laporan_id' => $laporan->id, 'new_last_report_at' => $masyarakat->last_report_at]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Laporan Berhasil Terkirim!'
        ]);
    }

    /**
     * Cek apakah titik ada di dalam polygon (GeoJSON)
     * @param array $point [lat, lon]
     * @param array $polygon array of [lon, lat]
     * @return bool
     */
    private function pointInPolygon($point, $polygon)
    {
        $x = $point[1]; // longitude
        $y = $point[0]; // latitude
        $inside = false;
        $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][1]; $yi = $polygon[$i][0];
            $xj = $polygon[$j][1]; $yj = $polygon[$j][0];
            $intersect = (($yi > $y) != ($yj > $y))
                && ($x < ($xj - $xi) * ($y - $yi) / (($yj - $yi) ?: 1e-10) + $xi);
            if ($intersect) $inside = !$inside;
        }
        return $inside;
    }

    public function laporanAktifMilikmu()
    {
        $user = Auth::user();
        $masyarakatId = $user->masyarakat->id ?? null;

        // Ambil semua laporan milik user ini, bisa filter status jika perlu
        $laporans = \App\Models\LaporanPengaduan::where('masyarakat_id', $masyarakatId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Dashboardstlhlogin.masyarakat.pengaduan.BuatLaporan4', compact('laporans'));
    }

    public function halamanBuatLaporan1()
    {
        $user = Auth::user();
        $masyarakatId = $user->masyarakat->id ?? null;

        $laporans = \App\Models\LaporanPengaduan::where('masyarakat_id', $masyarakatId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Dashboardstlhlogin.masyarakat.pengaduan.BuatLaporan1', compact('laporans'));
    }

    public function getAllLaporan()
    {
        $laporans = \App\Models\LaporanPengaduan::with(['tracking' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->get();

        $result = $laporans->map(function($laporan) {
            $lastTracking = $laporan->tracking->first();
            return [
                'id' => $laporan->id,
                'latitude' => $laporan->latitude,
                'longitude' => $laporan->longitude,
                'lokasi' => $laporan->lokasi,
                'status' => $laporan->status,
                'deskripsi' => $laporan->deskripsi,
                'created_at' => $laporan->created_at,
                'foto_video' => $laporan->foto_video,
                'sub_status' => $lastTracking ? $lastTracking->sub_status : null,
            ];
        });

        return response()->json($result);
    }

    public function showTracking($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with('tracking')->findOrFail($id);
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanMenunggu', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Di Proses,Selesai,Ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $laporan = LaporanPengaduan::findOrFail($id);

        // Update status laporan utama
        $laporan->status = $request->status;
        $laporan->save();

        // Tambah tracking baru
        TrackingLaporan::create([
            'pengaduan_id' => $laporan->id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'sub_status' => 'menunggu_verifikasi_admin',
        ]);

        // Update status semua laporan anak
        LaporanPengaduan::where('related_pengaduan_id', $laporan->id)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function tracking()
    {
        return $this->hasMany(TrackingLaporan::class);
    }

    public function laporanUtamaDinas(Request $request)
    {
        $status = $request->input('status');
        $q = $request->input('q');

        if ($status === 'Selesai') {
            // Tampilkan semua laporan selesai (tidak digabung)
            $query = LaporanPengaduan::where('status', 'Selesai');
        } elseif ($status) {
            // Tampilkan laporan utama untuk status lain
            $query = LaporanPengaduan::whereNull('related_pengaduan_id')->where('status', $status);
        } else {
            // Jika "Semua Status": gabungkan dua query
            $querySelesai = LaporanPengaduan::where('status', 'Selesai');
            $queryUtama = LaporanPengaduan::whereNull('related_pengaduan_id')->where('status', '!=', 'Selesai');
            // Gabungkan hasilnya
            $laporanUtama = $querySelesai->get()->merge($queryUtama->get())->sortByDesc('created_at');
            // Search filter
            if ($q) {
                $laporanUtama = $laporanUtama->filter(function($laporan) use ($q) {
                    return stripos($laporan->deskripsi, $q) !== false || stripos($laporan->lokasi, $q) !== false;
                });
            }
            return view('Dashboardstlhlogin.Dinas.AktivitasDinas.LaporanMasyarakat', [
                'laporanUtama' => $laporanUtama instanceof \Illuminate\Support\Collection ? $laporanUtama : collect($laporanUtama)
            ]);
        }

        // Search filter untuk status tertentu
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('deskripsi', 'like', "%$q%")
                    ->orWhere('lokasi', 'like', "%$q%");
            });
        }

        $laporanUtama = $query->orderBy('created_at', 'desc')->get();

        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.LaporanMasyarakat', compact('laporanUtama'));
    }

    public function tindaklanjutiLaporan($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);

        if ($laporan->status != 'Di Proses') {
            $laporan->status = 'Di Proses';
            $laporan->save();

            // Update semua laporan anak
            LaporanPengaduan::where('related_pengaduan_id', $laporan->id)->update(['status' => 'Di Proses']);

            // Tambahkan tracking baru untuk status Di Proses (proses awal)
            \App\Models\TrackingLaporan::create([
                'pengaduan_id' => $laporan->id,
                'status' => 'Di Proses',
                'sub_status' => 'proses',
                'keterangan' => 'Laporan sedang di Proses, di tindak lanjuti oleh dinas'
            ]);
        }

        // Ambil data like dan komentar
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $laporan->id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $laporan->id)->count();

        // Tampilkan view step4Diproses langsung agar variabel tersedia
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep4Diproses', [
            'laporan' => $laporan,
            'komentar' => $komentar,
            'likeCount' => $likeCount
        ]);
    }

    public function detailLaporanDinas($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        $penyelesaian = PenyelesaianLaporan::where('pengaduan_id', $laporan->id)->first();

        $trackProses = $laporan->tracking->where('status', 'Di Proses')->last();

        // Tambahkan pengecekan sub_status
        if ($trackProses && $trackProses->sub_status == 'menunggu_verifikasi_admin') {
            return redirect()->route('dinas.laporan.step7.lanjutan', $laporan->id);
        } elseif ($trackProses && $trackProses->sub_status == 'perlu_perbaikan_dinas') {
            return redirect()->route('dinas.laporan.step4.diproses', $laporan->id);
        }

        // Status Menunggu
        if ($laporan->status == 'Menunggu') {
            return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep1', compact('laporan'));
        }

        // Status Di Proses
        if ($laporan->status == 'Di Proses') {
            $penyelesaian = PenyelesaianLaporan::where('pengaduan_id', $laporan->id)->first();
            if ($penyelesaian) {
                return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep4Lanjutan', compact('laporan', 'penyelesaian'));
            } else {
                return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep4Diproses', compact('laporan'));
            }
        }

        // Status Selesai
        if ($laporan->status == 'Selesai') {
            // ... (jika ada step selesai)
        }

        // Default fallback
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep1', compact('laporan'));
    }

    public function detailLaporanMasyarakat($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with('tracking')->findOrFail($id);

        // Arahkan ke halaman yang sesuai berdasarkan status
        switch($laporan->status) {
            case 'Menunggu':
                return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanMenunggu', compact('laporan'));
            case 'Di Proses':
                return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanProses-diselesaikan', compact('laporan'));
            case 'Selesai':
                return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanSelesai', compact('laporan'));
            case 'Ditolak':
                return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanDitolak', compact('laporan'));
            default:
                return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanMenunggu', compact('laporan'));
        }
    }

    public function storePenyelesaian(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengerjaan' => 'required|date',
            'tanggal_estimasi_selesai' => 'required|date|after:tanggal_pengerjaan',
            'deskripsi_pengerjaan' => 'required|string',
        ]);

        $laporan = LaporanPengaduan::findOrFail($id);

        // Pastikan dinas_id diambil dari laporan, bukan dari user
        $dinasId = $laporan->dinas_id ?? 1; // fallback ke 1 jika null

        $penyelesaian = \App\Models\PenyelesaianLaporan::firstOrCreate(
            ['pengaduan_id' => $laporan->id],
            [
                'dinas_id' => $dinasId,
                'tanggal_mulai' => $request->tanggal_pengerjaan,
                'tanggal_selesai' => $request->tanggal_estimasi_selesai,
                'status' => 'On-Progress',
                'alasan_penolakan' => null,
                'deskripsi_pengerjaan' => $request->deskripsi_pengerjaan,
            ]
        );

        // Update status laporan
        $laporan->status = 'Di Proses';
        $laporan->save();

        // Redirect ke halaman lanjutan
        return redirect()->route('dinas.laporan.lanjutan', $laporan->id);
    }

    public function lanjutan($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        $penyelesaian = PenyelesaianLaporan::where('pengaduan_id', $laporan->id)->first();
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep4Lanjutan', compact('laporan', 'penyelesaian', 'komentar', 'likeCount'));
    }

    public function hasilFoto($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep6HasilFoto', compact('laporan'));
    }

    public function step7Lanjutan($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with('tracking')->findOrFail($id);
        $penyelesaian = \App\Models\PenyelesaianLaporan::where('pengaduan_id', $id)->first();
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep7Lanjutan', compact('laporan', 'penyelesaian', 'komentar', 'likeCount'));
    }

    public function step7Validasi($id)
    {
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep7Validasi', compact('laporan'));
    }

    public function selesaikanLaporan($id)
    {
        // Update status laporan dan penyelesaian
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);
        $penyelesaian = \App\Models\PenyelesaianLaporan::where('pengaduan_id', $id)->first();

        // Update status laporan
        $laporan->status = 'Selesai';
        $laporan->save();

        // Update status penyelesaian
        if ($penyelesaian) {
            $penyelesaian->status = 'Selesai';
            $penyelesaian->save();
        }

        // Redirect ke halaman sukses atau detail
        return redirect()->back()->with('success', 'Laporan berhasil diselesaikan!');
    }

    public function selesaikanStep6($id)
    {
        $laporan = LaporanPengaduan::findOrFail($id);

        // Update status dan sub_status
        $laporan->status = 'Di Proses';
        $laporan->save();

        // Tambahkan tracking baru
        TrackingLaporan::create([
            'pengaduan_id' => $laporan->id,
            'status' => 'Di Proses',
            'sub_status' => 'menunggu_verifikasi_admin',
            'keterangan' => 'Laporan Telah Diselesaikan, menunggu verifikasi admin'
        ]);

        // Update status semua laporan anak (jika ada)
        LaporanPengaduan::where('related_pengaduan_id', $laporan->id)->update(['status' => 'Di Proses']);

        // Redirect ke halaman step 7 lanjutan
        return redirect()->route('dinas.laporan.step7.lanjutan', $laporan->id)
            ->with('success', 'Laporan menunggu verifikasi admin.');
    }

    public function showTrackingMenunggu($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanMenunggu', compact('laporan'));
    }

    public function showTrackingProsesDitindaklanjuti($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        $komentar = KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = LikeLaporan::where('pengaduan_id', $id)->count();
        $liked = LikeLaporan::where('pengaduan_id', $id)->where('user_id', auth()->user()->id)->exists();
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanProses-ditindaklanjuti', compact('laporan', 'komentar', 'likeCount', 'liked'));
    }

    public function showTrackingProsesDiselesaikan($id)
    {
        $laporan = LaporanPengaduan::with('tracking')->findOrFail($id);
        $komentar = KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = LikeLaporan::where('pengaduan_id', $id)->count();
        $liked = LikeLaporan::where('pengaduan_id', $id)->where('user_id', auth()->user()->id)->exists();
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanProses-diselesaikan', compact('laporan', 'komentar', 'likeCount', 'liked'));
    }

    public function showTrackingSelesai($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian', 'ulasan'])->findOrFail($id);

        if ($laporan->related_pengaduan_id) {
            $laporanUtama = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian', 'ulasan'])->find($laporan->related_pengaduan_id);
            if ($laporanUtama) {
                $penyelesaian = $laporanUtama->penyelesaian;
                $tracking = $laporanUtama->tracking;
                $ulasan = $laporanUtama->ulasan;
                $status_laporan = $laporanUtama->status;
                $updated_at = $laporanUtama->updated_at;
            } else {
                $penyelesaian = $laporan->penyelesaian;
                $tracking = $laporan->tracking;
                $ulasan = $laporan->ulasan;
                $status_laporan = $laporan->status;
                $updated_at = $laporan->updated_at;
            }
        } else {
            $penyelesaian = $laporan->penyelesaian;
            $tracking = $laporan->tracking;
            $ulasan = $laporan->ulasan;
            $status_laporan = $laporan->status;
            $updated_at = $laporan->updated_at;
        }

        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanSelesai', [
            'laporan' => $laporan,
            'penyelesaian' => $penyelesaian,
            'tracking' => $tracking,
            'ulasan' => $ulasan,
            'status_laporan' => $status_laporan,
            'updated_at' => $updated_at,
        ]);
    }

    public function showTrackingDitolak($id)
    {
        $laporan = LaporanPengaduan::with(['penyelesaian', 'tracking'])->findOrFail($id);
        $alasan_penolakan = $laporan->penyelesaian->alasan_penolakan ?? '';
        $waktu_tolak = $laporan->penyelesaian->waktu_tolak ?? $laporan->updated_at;
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanDitolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak'));
    }

    public function step4Diproses($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking'])->findOrFail($id);
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep4Diproses', compact('laporan', 'komentar', 'likeCount'));
    }

    public function adminVerifikasiLaporan(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:selesai,ditolak',
            'keterangan' => 'nullable|string'
        ]);
        $laporan = LaporanPengaduan::findOrFail($id);
        $admin = \App\Models\Admin::first(); // karena hanya 1 admin

        if ($request->aksi == 'selesai') {
            $laporan->status = 'Selesai';
            $laporan->save();

            \App\Models\TrackingLaporan::create([
                'pengaduan_id' => $laporan->id,
                'status' => 'Selesai',
                'sub_status' => 'verifikasi_admin',
                'keterangan' => $request->keterangan ?? 'Laporan diverifikasi selesai oleh admin',
                'id_admin' => $admin->id
            ]);

            // === TAMBAH LOGIKA INI UNTUK POINT DINAS ===
            $dinas = $laporan->dinas; // Asumsi ada relasi 'dinas' di model LaporanPengaduan
            if ($dinas) {
                $dinas->point += 10;
                // Cek jika poin mencapai atau melebihi 100
                if ($dinas->point >= 100) {
                    // Simpan poin sebelum reset untuk menentukan warna teks di view (jika diperlukan di view, tapi logic di view sudah based on current point)
                    // Untuk reset: set poin ke 0. Logic warna teks di view akan menangani poin 0.
                    $dinas->point = 0;
                    // Di sini Anda bisa menambahkan logika lain jika ada, misalnya mencatat bahwa dinas mencapai level tertentu sebelum reset.
                }
                $dinas->save();
                \Log::info('Dinas mendapat 10 poin dari verifikasi admin', ['dinas_id' => $dinas->id, 'current_point' => $dinas->point]);
            }
            // ============================================

        } else {
            $laporan->status = 'Di Proses';
            $laporan->save();

            \App\Models\TrackingLaporan::create([
                'pengaduan_id' => $laporan->id,
                'status' => 'Di Proses',
                'sub_status' => 'perlu_perbaikan_dinas',
                'keterangan' => $request->keterangan ?? 'Laporan ditolak oleh admin, perlu perbaikan oleh dinas',
                'id_admin' => $admin->id
            ]);
        }

        // Update status semua laporan anak
        LaporanPengaduan::where('related_pengaduan_id', $laporan->id)->update(['status' => $laporan->status]);

        return redirect()->route('admin.laporan')->with('success', 'Laporan berhasil diverifikasi!');
    }

    public function adminDetailLaporan($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['penyelesaian', 'tracking'])->findOrFail($id);
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        $foto_video = $laporan->foto_video;
        $penyelesaian = $laporan->penyelesaian;
        $trackingUtama = $laporan->tracking;
        return view('Dashboardstlhlogin.Admin.Laporan.DetailLaporan', compact('laporan', 'komentar', 'likeCount', 'foto_video', 'penyelesaian', 'trackingUtama'));
    }

    public function indexLaporanAdmin(Request $request)
    {
        $q = $request->input('q');
        $statusFilter = $request->input('status');

        // Query dasar: status Selesai
        $selesai = \App\Models\LaporanPengaduan::with('tracking')
            ->where('status', 'Selesai');

        // Query dasar: status Di Proses & sub_status menunggu_verifikasi_admin
        $menungguVerif = \App\Models\LaporanPengaduan::with('tracking')
            ->where('status', 'Di Proses')
            ->whereHas('tracking', function($q) {
                $q->where('sub_status', 'menunggu_verifikasi_admin');
            });

        // Filter search
        if ($q) {
            $selesai->where(function($query) use ($q) {
                $query->where('deskripsi', 'like', "%$q%")
                      ->orWhere('lokasi', 'like', "%$q%");
            });
            $menungguVerif->where(function($query) use ($q) {
                $query->where('deskripsi', 'like', "%$q%")
                      ->orWhere('lokasi', 'like', "%$q%");
            });
        }

        // Filter dropdown status
        if ($statusFilter == 'selesai') {
            $selesai = $selesai->get();
            $menungguVerif = collect();
        } elseif ($statusFilter == 'menunggu_verifikasi_admin') {
            $selesai = collect();
            $menungguVerif = $menungguVerif->get();
        } else {
            $selesai = $selesai->get();
            $menungguVerif = $menungguVerif->get();
        }

        $laporans = $selesai->merge($menungguVerif);

        return view('Dashboardstlhlogin.Admin.Laporan.Laporan', compact('laporans', 'statusFilter', 'q'));
    }

    public function adminDetailLaporanSelesai($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian', 'ulasan'])->findOrFail($id);
        $penyelesaian = $laporan->penyelesaian;
        $foto_video = $laporan->foto_video;
        $trackingUtama = $laporan->tracking;
        $ulasan = $laporan->ulasan;
        if ($laporan->related_pengaduan_id) {
            $laporanUtama = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian'])->find($laporan->related_pengaduan_id);
            if ($laporanUtama) {
                $penyelesaian = $laporanUtama->penyelesaian;
                $foto_video = $laporanUtama->foto_video;
                $trackingUtama = $laporanUtama->tracking;
            }
        }
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Admin.Laporan.DetailLaporanSelesai', [
            'laporan' => $laporan,
            'penyelesaian' => $penyelesaian,
            'foto_video' => $foto_video,
            'trackingUtama' => $trackingUtama,
            'ulasan' => $ulasan,
            'komentar' => $komentar,
            'likeCount' => $likeCount
        ]);
    }

    public function dinasDetailLaporanSelesai($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian', 'ulasan'])->findOrFail($id);
        $penyelesaian = $laporan->penyelesaian;
        $tracking = $laporan->tracking;
        $ulasan = $laporan->ulasan;
        if ($laporan->related_pengaduan_id) {
            $laporanUtama = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian'])->find($laporan->related_pengaduan_id);
            if ($laporanUtama) {
                $penyelesaian = $laporanUtama->penyelesaian;
                $tracking = $laporanUtama->tracking;
            }
        }
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep8Selesai', compact('laporan', 'penyelesaian', 'tracking', 'ulasan', 'komentar', 'likeCount'));
    }

    public function kirimUlasan(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:1000'
        ]);

        $laporan = LaporanPengaduan::findOrFail($id);
        $masyarakat = auth()->user()->masyarakat; // Ambil model Masyarakat
        $masyarakatId = $masyarakat->id;

        // Cegah double ulasan
        if ($laporan->ulasan) {
            return redirect()->route('masyarakat.laporan.ulasan', $laporan->id)->with('error', 'Ulasan sudah pernah dikirim.');
        }

        UlasanLaporan::create([
            'laporan_id' => $laporan->id,
            'masyarakat_id' => $masyarakatId,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan
        ]);

        // TAMBAH POIN UNTUK MASYARAKAT (INI SUDAH ADA)
        $masyarakat->increment('poin', 5);
        \Log::info('Masyarakat mendapat 5 poin dari ulasan', ['user_id' => $masyarakat->user_id, 'current_poin' => $masyarakat->poin]);

        // === TAMBAH LOGIKA INI UNTUK POINT DINAS ===
        $dinas = $laporan->dinas; // Ambil dinas yang menangani laporan
        if ($dinas) {
            $dinas->point += $request->rating; // Tambahkan poin sejumlah rating
            $dinas->save();
            \Log::info('Dinas mendapat ' . $request->rating . ' poin dari ulasan masyarakat', ['dinas_id' => $dinas->id, 'rating' => $request->rating, 'current_point' => $dinas->point]);
        }
        // ============================================

        return redirect()->route('masyarakat.laporan.ulasan', $laporan->id)->with('success', 'Ulasan berhasil dikirim!');
    }

    public function lihatUlasan($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['ulasan', 'penyelesaian', 'tracking'])->findOrFail($id);
        $ulasan = $laporan->ulasan;
        $penyelesaian = $laporan->penyelesaian;
        $tracking = $laporan->tracking;
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        $liked = \App\Models\LikeLaporan::where('pengaduan_id', $id)->where('user_id', auth()->user()->id)->exists();
        // Jika laporan anak, ambil penyelesaian & tracking dari utama
        if ($laporan->related_pengaduan_id) {
            $laporanUtama = \App\Models\LaporanPengaduan::with(['penyelesaian', 'tracking'])->find($laporan->related_pengaduan_id);
            if ($laporanUtama) {
                $penyelesaian = $laporanUtama->penyelesaian;
                $tracking = $laporanUtama->tracking;
            }
        }
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanUlasan', compact('laporan', 'ulasan', 'penyelesaian', 'tracking', 'komentar', 'likeCount', 'liked'));
    }

    public function tolakLaporan(Request $request, $id)
    {
        \Log::info('Masuk ke tolakLaporan', ['request' => $request->all(), 'id' => $id]);
        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000'
        ]);

        $laporan = LaporanPengaduan::findOrFail($id);

        // Update status laporan & semua anak
        $laporan->status = 'Ditolak';
        $laporan->save();
        LaporanPengaduan::where('related_pengaduan_id', $laporan->id)->update(['status' => 'Ditolak']);

        // Tambahkan baris ini sebelum TrackingLaporan::create
        $admin = \App\Models\Admin::first();

        TrackingLaporan::create([
            'pengaduan_id' => $laporan->id,
            'status' => 'Di Proses',
            'sub_status' => 'perlu_perbaikan_dinas',
            'keterangan' => $request->alasan_penolakan,
            'id_admin' => $admin->id
        ]);

        // Pastikan dinas_id terisi (default ke 1 jika null)
        $dinas_id = $laporan->dinas_id ?? 1;

        // Buat baris baru di penyelesaian_laporan jika belum ada
        $penyelesaian = PenyelesaianLaporan::where('pengaduan_id', $laporan->id)->first();
        if (!$penyelesaian) {
            PenyelesaianLaporan::create([
                'pengaduan_id' => $laporan->id,
                'dinas_id' => $dinas_id,
                'status' => 'Ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
                'waktu_tolak' => now(),
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'foto_penyelesaian' => null,
                'deskripsi_pengerjaan' => null,
                'waktu_foto' => null,
                'alamat_foto' => null,
            ]);
        } else {
            $penyelesaian->alasan_penolakan = $request->alasan_penolakan;
            $penyelesaian->waktu_tolak = now();
            $penyelesaian->status = 'Ditolak';
            $penyelesaian->save();
        }

        // Ambil user_id masyarakat pelapor
        $masyarakat = $laporan->masyarakat; // relasi ke model Masyarakat
        $userMasyarakat = $masyarakat->user_id ?? null;

        // Ambil user_id admin (asumsi hanya 1 admin)
        $admin = \App\Models\Admin::first();
        $userAdmin = $admin->user_id ?? null;

        // Data notifikasi
        $judul = 'Laporan ditolak oleh Dinas';
        $isi = 'Laporan Anda telah ditolak oleh Dinas. Alasan: ' . $request->alasan_penolakan;
        $now = now();

        // Notifikasi untuk masyarakat
        if ($userMasyarakat) {
            \App\Models\Notifikasi::create([
                'user_id' => $userMasyarakat,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'Penolakan',
                'created_at' => $now,
            ]);
        }

        // Notifikasi untuk admin
        if ($userAdmin) {
            \App\Models\Notifikasi::create([
                'user_id' => $userAdmin,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'Penolakan',
                'created_at' => $now,
            ]);
        }

        // Ambil user_id pusat (asumsi hanya 1 pusat)
        $pusat = \App\Models\PemerintahPusatDinas::first(); // Ganti dengan model pusat yang benar
        $userPusat = $pusat->user_id ?? null;

        // Notifikasi untuk pusat
        if ($userPusat) {
            \App\Models\Notifikasi::create([
                'user_id' => $userPusat,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'Penolakan',
                'role_tujuan' => 'pemerintahpusat',
                'created_at' => $now,
            ]);
        }

        // Redirect ke halaman ditolak
        return redirect()->route('dinas.laporan.step2.ditolak', $laporan->id);
    }

    public function showStep2Ditolak($id)
    {
        $laporan = LaporanPengaduan::with(['penyelesaian', 'tracking'])->findOrFail($id);
        $alasan_penolakan = $laporan->penyelesaian->alasan_penolakan ?? '';
        $waktu_tolak = $laporan->penyelesaian->waktu_tolak ?? $laporan->updated_at;
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep2Ditolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak'));
    }

    public function getNotifikasi()
    {
        $notifikasis = \App\Models\Notifikasi::where('user_id', Auth::id())
            ->where('jenis_notifikasi', 'Penolakan')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Dashboardstlhlogin.masyarakat.notifikasi', compact('notifikasis'));
    }

    public function notifikasiMasyarakat()
    {
        $user = auth()->user();
        $notifikasis = \App\Models\Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Dashboardstlhlogin.masyarakat.notifikasimasyarakat', compact('notifikasis'));
    }

    public function notifikasiAdmin()
    {
        $user = auth()->user();
        $notifikasis = \App\Models\Notifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Dashboardstlhlogin.Admin.Notifikasi.Notifikasi', compact('notifikasis'));
    }

    public function detailNotifikasiLaporanDitolak($id)
    {
        $notifikasi = \App\Models\Notifikasi::findOrFail($id);
        $laporan = $notifikasi->laporan;
        $alasan_penolakan = $laporan->penyelesaian->alasan_penolakan ?? '';
        $waktu_tolak = $laporan->penyelesaian->waktu_tolak ?? $laporan->updated_at;
        return view('Dashboardstlhlogin.Admin.Notifikasi.NotifikasiLaporanDitolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak', 'notifikasi'));
    }

    public function detailNotifikasiMasyarakatDitolak($id)
    {
        $notifikasi = \App\Models\Notifikasi::findOrFail($id);
        $laporan = $notifikasi->laporan;
        $alasan_penolakan = $laporan->penyelesaian->alasan_penolakan ?? '';
        $waktu_tolak = $laporan->penyelesaian->waktu_tolak ?? $laporan->updated_at;
        return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanDitolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak', 'notifikasi'));
    }

    public static function countUnreadNotifikasi($userId)
    {
        return \App\Models\Notifikasi::where('user_id', $userId)
            ->where('status_notifikasi', 'Terkirim')
            ->count();
    }

    public function dismissNotif($id)
    {
        $notif = \App\Models\Notifikasi::findOrFail($id);
        if ($notif->user_id == auth()->id()) {
            $notif->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 403);
    }

    public function readNotif($id)
    {
        $notif = \App\Models\Notifikasi::findOrFail($id);
        if ($notif->user_id == auth()->id()) {
            $notif->status_notifikasi = 'Dibaca';
            $notif->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 403);
    }

    public function adminTolakLaporan(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000'
        ]);
        $laporan = \App\Models\LaporanPengaduan::with('tracking')->findOrFail($id);

        // Buat notifikasi ke dinas
        $dinas = $laporan->dinas;
        $userDinas = $dinas->user_id ?? null;

        $judul = 'Laporan ditolak oleh Pemerintah Admin';
        $isi = 'Laporan Anda ditolak oleh Admin. Alasan: ' . $request->alasan_penolakan;
        $now = now();

        if ($userDinas) {
            \App\Models\Notifikasi::create([
                'user_id' => $userDinas,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'Penolakan',
                'role_tujuan' => 'dinas',
                'alasan_penolakan' => $request->alasan_penolakan,
                'waktu_tolak' => $now,
                'created_at' => $now,
            ]);
        }

        // Redirect ke halaman detail penolakan admin
        return redirect()->route('admin.laporan.ditolak', $laporan->id);
    }

    public function notifikasiDinas()
    {
        $user = auth()->user();
        $notifikasis = \App\Models\Notifikasi::where('user_id', $user->id)
            ->where('role_tujuan', 'dinas')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Dashboardstlhlogin.Dinas.Notifikasi.Notifikasi-Dinas', compact('notifikasis'));
    }

    public function detailNotifikasiDinasDitolak($id)
    {
        $notifikasi = \App\Models\Notifikasi::findOrFail($id);
        $laporan = $notifikasi->laporan;
        $alasan_penolakan = $notifikasi->alasan_penolakan;
        $waktu_tolak = $notifikasi->waktu_tolak;
        // Redirect ke halaman detail laporan ditolak
        return redirect()->route('dinas.laporan.step9.ditolak', ['id' => $laporan->id]);
    }

    public function dinasStep9Ditolak($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['penyelesaian', 'tracking'])->findOrFail($id);
        $notifikasi = \App\Models\Notifikasi::where('pengaduan_id', $id)
            ->where('role_tujuan', 'dinas')
            ->orderBy('waktu_tolak', 'desc')
            ->first();
        $alasan_penolakan = $notifikasi->alasan_penolakan ?? '';
        $waktu_tolak = $notifikasi->waktu_tolak ?? $laporan->updated_at;
        $penyelesaian = $laporan->penyelesaian;
        $tracking = $laporan->tracking;
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep9Ditolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak', 'notifikasi', 'penyelesaian', 'tracking', 'komentar', 'likeCount'));
    }

    public function adminDetailLaporanDitolak($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['penyelesaian', 'tracking'])->findOrFail($id);
        $notifikasi = \App\Models\Notifikasi::where('pengaduan_id', $id)
            ->where('role_tujuan', 'dinas')
            ->orderBy('waktu_tolak', 'desc')
            ->first();
        $alasan_penolakan = $notifikasi->alasan_penolakan ?? '';
        $waktu_tolak = $notifikasi->waktu_tolak ?? $laporan->updated_at;
        $penyelesaian = $laporan->penyelesaian;
        $tracking = $laporan->tracking;
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.Admin.Laporan.DetailLaporanDitolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak', 'penyelesaian', 'notifikasi', 'tracking', 'komentar', 'likeCount'));
    }

    public function escalateUnfinishedLaporan()
    {
        $now = now();
        $penyelesaianList = \App\Models\PenyelesaianLaporan::where('status', 'On-Progress')
            ->where('tanggal_selesai', '<', $now)
            ->get();

        foreach ($penyelesaianList as $penyelesaian) {
            $laporan = \App\Models\LaporanPengaduan::find($penyelesaian->pengaduan_id);
            if (!$laporan) continue;

            // Cek tracking terakhir
            $lastTracking = \App\Models\TrackingLaporan::where('pengaduan_id', $laporan->id)
                ->orderBy('created_at', 'desc')->first();

            // Jika sudah ada tracking Selesai, Ditolak, atau menunggu_verifikasi_admin, SKIP
            $adaTrackingFinal = \App\Models\TrackingLaporan::where('pengaduan_id', $laporan->id)
                ->whereIn('status', ['Selesai', 'Ditolak'])
                ->orWhere(function($q) {
                    $q->where('status', 'Di Proses')->where('sub_status', 'menunggu_verifikasi_admin');
                })
                ->exists();

            if ($adaTrackingFinal) continue;

            // Update status penyelesaian
            $penyelesaian->status = 'Tidak Terselesaikan';
            $penyelesaian->save();

            // Update laporan_pengaduan
            $laporan->escalated_to_pusat = 1;
            $laporan->save();

            // Tambahkan tracking jika belum ada
            $sudahAda = \App\Models\TrackingLaporan::where('pengaduan_id', $laporan->id)
                ->where('status', 'Tidak Terselesaikan')
                ->where('escalated_to_pusat', 1)
                ->exists();
            if (!$sudahAda) {
                \App\Models\TrackingLaporan::create([
                    'pengaduan_id' => $laporan->id,
                    'status' => 'Tidak Terselesaikan',
                    'keterangan' => 'Laporan tidak terselesaikan tepat waktu',
                    'escalated_to_pusat' => 1,
                ]);
            }
        }
    }

    /**
     * Tampilkan laporan yang sudah di-escalate ke pusat (untuk pemerintah pusat)
     */
    public function laporanPusat()
    {
        // Ambil laporan yang di-escalate ke pusat dan statusnya Menunggu
        $belumRespon = \App\Models\LaporanPengaduan::where('escalated_to_pusat', 1)
            ->where('status', 'Menunggu')
            ->get();

        // Ambil laporan yang tracking terakhirnya "Tidak Terselesaikan"
        $trackingIds = \App\Models\TrackingLaporan::where('escalated_to_pusat', 1)
            ->where('status', 'Tidak Terselesaikan')
            ->pluck('pengaduan_id');
        $tidakTerselesaikan = \App\Models\LaporanPengaduan::whereIn('id', $trackingIds)->get();

        // Gabungkan
        $laporans = $belumRespon->merge($tidakTerselesaikan);

        // FILTER: Hapus laporan yang tracking terakhirnya sub_status == 'menunggu_verifikasi_admin'
        $laporans = $laporans->filter(function($laporan) {
            $lastTracking = $laporan->tracking->sortByDesc('created_at')->first();
            // Hapus jika status "Tidak Terselesaikan" DAN sub_status terakhir "menunggu_verifikasi_admin"
            if ($laporan->status == 'Tidak Terselesaikan' && $lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin') {
                return false;
            }
            // Hapus juga jika sub_status terakhir "menunggu_verifikasi_admin" (opsional, jika ingin lebih strict)
            if ($lastTracking && $lastTracking->sub_status == 'menunggu_verifikasi_admin') {
                return false;
            }
            return true;
        });

        return view('Dashboardstlhlogin.pemerintahpusat.laporan-pusat', compact('laporans'));
    }

    public function detailBelumResponPusat($id)
    {
        $laporan = LaporanPengaduan::findOrFail($id);

        // Cek apakah sudah ada pesan dari pusat ke dinas untuk laporan ini
        $pesan = Notifikasi::where('pengaduan_id', $id)
            ->where('jenis_notifikasi', 'PesanPusat')
            ->first();
        if ($pesan) {
            // Sudah pernah kirim pesan, redirect ke halaman pesan
            return redirect()->route('pemerintahpusat.laporan.pesanBelumDirespon', $id);
        }
        // Belum pernah kirim pesan, tampilkan form kirim pesan
        return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumdirespon.belumdirespon', compact('laporan'));
    }

    public function kirimPesanPusatKeDinas(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000'
        ]);
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);

        // Ambil user dinas tujuan
        $dinas = $laporan->dinas;
        $userDinas = $dinas->user_id ?? null;

        // Data notifikasi
        $judul = 'Pesan dari Pemerintah Pusat';
        $isi = $request->isi_pesan;
        $now = now();

        // Simpan notifikasi ke dinas
        if ($userDinas) {
            \App\Models\Notifikasi::create([
                'user_id' => $userDinas,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'PesanPusat',
                'role_tujuan' => 'dinas',
                'created_at' => $now,
            ]);
        }

        // Redirect ke halaman pesan pusat (untuk pusat)
        return redirect()->route('pemerintahpusat.laporan.pesanBelumDirespon', $laporan->id)
            ->with('success', 'Pesan berhasil dikirim ke dinas.');
    }

    public function pesanBelumDiresponPusat($id)
    {
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);
        // Ambil notifikasi terbaru dari pusat ke dinas untuk laporan ini
        $pesan = Notifikasi::where('pengaduan_id', $id)
            ->where('jenis_notifikasi', 'PesanPusat')
            ->orderBy('created_at', 'desc')
            ->first();

        $isi_pesan = $pesan->isi_notifikasi ?? '';
        $waktu_kirim = $pesan->created_at ?? null;

        return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumdirespon.PesanBelumDirespon', compact('laporan', 'isi_pesan', 'waktu_kirim'));
    }

    public function pesanBelumDiresponDinas($id)
    {
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);
        // Ambil notifikasi terbaru dari pusat ke dinas untuk laporan ini
        $pesan = Notifikasi::where('pengaduan_id', $id)
            ->where('jenis_notifikasi', 'PesanPusat')
            ->orderBy('created_at', 'desc')
            ->first();

        $isi_pesan = $pesan->isi_notifikasi ?? '';
        $waktu_kirim = $pesan->created_at ?? null;

        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.PesanBelumDiresponDinas', compact('laporan', 'isi_pesan', 'waktu_kirim'));
    }

    public function pesanTidakTerselesaikanDinas($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian'])->findOrFail($id);
        $pesan = Notifikasi::where('pengaduan_id', $id)
            ->where('jenis_notifikasi', 'PesanPusat')
            ->orderBy('created_at', 'desc')
            ->first();

        $isi_pesan = $pesan->isi_notifikasi ?? '';
        $waktu_kirim = $pesan->created_at ?? null;

        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.PesanTidakTerselesaikan', compact('laporan', 'isi_pesan', 'waktu_kirim'));
    }

    public function escalateMenungguLaporan()
    {
        $laporans = \App\Models\LaporanPengaduan::where('status', 'Menunggu')
            ->where('waktu_menunggu_expired', '<', now())
            ->where('escalated_to_pusat', 0)
            ->get();

        foreach ($laporans as $laporan) {
            $laporan->escalated_to_pusat = 1;
            $laporan->save();
            // Jangan ubah status!
        }

        return 'Eskalasi selesai';
    }

    public function kirimPesanBelumTerselesaikan(Request $request, $id)
    {
        $request->validate([
            'isi_pesan' => 'required|string|max:1000'
        ]);
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);

        // Ambil user dinas tujuan
        $dinas = $laporan->dinas;
        $userDinas = $dinas->user_id ?? null;

        // Data notifikasi
        $judul = 'Pesan dari Pemerintah Pusat';
        $isi = $request->isi_pesan;
        $now = now();

        // Simpan notifikasi ke dinas
        if ($userDinas) {
            \App\Models\Notifikasi::create([
                'user_id' => $userDinas,
                'pengaduan_id' => $laporan->id,
                'judul_notifikasi' => $judul,
                'isi_notifikasi' => $isi,
                'status_notifikasi' => 'Terkirim',
                'jenis_notifikasi' => 'PesanPusat',
                'role_tujuan' => 'dinas',
                'created_at' => $now,
            ]);
        }

        // Redirect ke halaman pesan pusat (untuk pusat)
        return redirect()->route('pemerintahpusat.laporan.pesanBelumTerselesaikan', $laporan->id)
            ->with('success', 'Pesan berhasil dikirim ke dinas.');
    }

    public function pesanBelumTerselesaikanPusat($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with(['tracking', 'penyelesaian'])->findOrFail($id);
        $pesan = Notifikasi::where('pengaduan_id', $id)
            ->where('jenis_notifikasi', 'PesanPusat')
            ->orderBy('created_at', 'desc')
            ->first();

        $isi_pesan = $pesan->isi_notifikasi ?? '';
        $waktu_kirim = $pesan->created_at ?? null;

        return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumterselesaikan.PesanBelumTerselesaikan', compact('laporan', 'isi_pesan', 'waktu_kirim'));
    }

    public function notifikasiPusat()
    {
        $user = auth()->user();
        $notifikasis = \App\Models\Notifikasi::where(function($q) use ($user) {
                $q->where('role_tujuan', 'pemerintahpusat')
                  ->orWhere('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $unreadNotifCount = $notifikasis->where('status_notifikasi', 'Terkirim')->count();

        return view('Dashboardstlhlogin.pemerintahpusat.notifikasi.notifikasi', compact('notifikasis', 'unreadNotifCount'));
    }

    public function detailNotifikasiPusatDitolak($id)
    {
        $notifikasi = \App\Models\Notifikasi::findOrFail($id);
        $laporan = $notifikasi->laporan;
        $alasan_penolakan = $laporan->penyelesaian->alasan_penolakan ?? '';
        $waktu_tolak = $laporan->penyelesaian->waktu_tolak ?? $laporan->updated_at;
        return view('Dashboardstlhlogin.pemerintahpusat.notifikasi.notifikasiditolak', compact('laporan', 'alasan_penolakan', 'waktu_tolak', 'notifikasi'));
    }

    public function laporanBelumTerselesaikan($id)
    {
        $laporan = \App\Models\LaporanPengaduan::findOrFail($id);
        $komentar = \App\Models\KomentarLaporan::where('pengaduan_id', $id)->with('user')->latest()->get();
        $likeCount = \App\Models\LikeLaporan::where('pengaduan_id', $id)->count();
        return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumterselesaikan.laporan-belumterselesaikan', compact('laporan', 'komentar', 'likeCount'));
    }

    public function laporanSayaMasyarakat()
    {
        $user = auth()->user();
        $masyarakatId = $user->masyarakat->id ?? null;
        $laporans = \App\Models\LaporanPengaduan::with('tracking')
            ->where('masyarakat_id', $masyarakatId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat.LaporanSayaMasyarakat', compact('laporans'));
    }

    public function laporanWargaMasyarakat(Request $request)
    {
        $user = auth()->user();
        $masyarakatId = $user->masyarakat->id ?? null;

        $query = \App\Models\LaporanPengaduan::with('tracking')
            ->where('masyarakat_id', '!=', $masyarakatId);

        // Optional: filter pencarian
        if ($request->has('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('deskripsi', 'like', "%$q%")
                    ->orWhere('lokasi', 'like', "%$q%");
            });
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $laporans = $query->orderBy('created_at', 'desc')->get();

        return view('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat.LaporanWargaMasyarakat', compact('laporans'));
    }

    public function statistikPemerintahMasyarakat()
    {
        // Ambil semua data dinas (untuk tabel)
        $dinasList = \App\Models\Dinas::all();

        // Hitung laporan Selesai, Di Proses, dan Ditolak untuk semua dinas (total)
        $ditolakCount = \App\Models\LaporanPengaduan::where('status', 'Ditolak')->count();
        $selesaiCount = \App\Models\LaporanPengaduan::where('status', 'Selesai')->count();
        $prosesCount = \App\Models\LaporanPengaduan::where('status', 'Di Proses')->count();

        if (auth()->check()) {
            return view('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat.StatistikPemerintahMasyarakat', compact('dinasList', 'ditolakCount', 'selesaiCount', 'prosesCount'));
        } else {
            return view('DasboardBelumLogin.Aktivitas.StatistikPemerintah', compact('dinasList', 'ditolakCount', 'selesaiCount', 'prosesCount'));
        }
    }

    public function storeKomentar(Request $request, $id)
    {
        $request->validate(['isi_komentar' => 'required|string|max:1000']);
        KomentarLaporan::create([
            'pengaduan_id' => $id,
            'user_id' => auth()->user()->id,
            'isi_komentar' => $request->isi_komentar,
        ]);
        return back();
    }

    public function storeLike(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $like = LikeLaporan::where('pengaduan_id', $id)->where('user_id', $userId)->first();
        if ($like) {
            $like->delete(); // Unlike
        } else {
            LikeLaporan::create([
                'pengaduan_id' => $id,
                'user_id' => $userId,
            ]);
        }
        return back();
    }
}