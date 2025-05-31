<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\LaporanPengaduanController;
use App\Http\Controllers\DinasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PusatController;
use App\Models\LaporanPengaduan;
use App\Models\Dinas;

// Public Routes (No Authentication Required)
Route::get('/', function () {
    return view('DasboardBelumLogin.DasboardBelumLogin');
})->name('home');

Route::get('/home', function () {
    return view('DasboardBelumLogin.DasboardBelumLogin');
})->name('home.alias');

// Public Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/register', function () {
    return view('auth.Register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.ForgotPassword');
})->name('password.request');

// Public Content Routes
Route::get('/pengaduan', function () {
    return view('DasboardBelumLogin.PengaduanBelumLogin');
})->name('pengaduan');

Route::get('/aktivitas', function () {
    return view('DasboardBelumLogin.AktivitasBelumLogin');
})->name('aktivitas');

Route::get('/panduan', function () {
    return view('DasboardBelumLogin.PanduanBelumLogin');
})->name('panduan');

// Public Activity Routes
Route::get('/LaporanSaya', function () {
    return view('DasboardBelumLogin.Aktivitas.LaporanSaya');
})->name('laporan.saya');

Route::get('/StatistikPemerintah', function () {
    $dinasList = Dinas::all();
    $ditolakCount = LaporanPengaduan::where('status', 'Ditolak')->count();
    $selesaiCount = LaporanPengaduan::where('status', 'Selesai')->count();
    $prosesCount = LaporanPengaduan::where('status', 'Di Proses')->count();
    return view('DasboardBelumLogin.Aktivitas.StatistikPemerintah', compact('dinasList', 'ditolakCount', 'selesaiCount', 'prosesCount'));
})->name('pemerintah.statistik');

Route::get('/LaporanWarga', function () {
    $laporans = LaporanPengaduan::with('tracking')->latest()->get();
    return view('DasboardBelumLogin.Aktivitas.LaporanWarga', compact('laporans'));
})->name('laporan.warga');

// Auth Processing Routes
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.ResetPassword', ['token' => $token]);
})->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Masyarakat Routes
    Route::middleware(['auth', 'role:masyarakat'])->group(function () {
        Route::get('/masyarakat/dashboard', function () {
            return view('Dashboardstlhlogin.masyarakat.DasboardMasyarakat');
        })->name('masyarakat.dashboard');

        Route::get('/masyarakat/pengaduan', function () {
            return view('Dashboardstlhlogin.masyarakat.PengaduanMasyarakat');
        })->name('masyarakat.pengaduan');

        Route::get('/masyarakat/pengaduan/buat/1', [LaporanPengaduanController::class, 'halamanBuatLaporan1'])->name('masyarakat.pengaduan.buat.step1');

        Route::get('/masyarakat/pengaduan/buat/2', function () {
            return view('Dashboardstlhlogin.masyarakat.pengaduan.BuatLaporan2');
        })->name('masyarakat.pengaduan.buat.step2');

        Route::get('/masyarakat/pengaduan/buat/3', function () {
            return view('Dashboardstlhlogin.masyarakat.pengaduan.BuatLaporan3');
        })->name('masyarakat.pengaduan.buat.step3');

        Route::get('/masyarakat/pengaduan/buat/4', [LaporanPengaduanController::class, 'laporanAktifMilikmu'])->name('masyarakat.pengaduan.buat.step4');

        Route::post('/submit-laporan', [LaporanPengaduanController::class, 'store'])->name('laporan.store');
        Route::get('/masyarakat/check-cooldown', function () {
            $user = Auth::user();
            $masyarakat = $user->masyarakat;
            $lastReport = $masyarakat->last_report_at;
            $canReport = true;
            $remainingTime = null;

            if ($lastReport) {
                $now = now();
                $nextReportTime = \Carbon\Carbon::parse($lastReport)->addMinutes(2);
                if ($now->lt($nextReportTime)) {
                    $canReport = false;
                    $remainingTime = [
                        'minutes' => $now->diffInMinutes($nextReportTime),
                        'seconds' => $now->diffInSeconds($nextReportTime) % 60,
                        'total_seconds' => $now->diffInSeconds($nextReportTime)
                    ];
                }
            }

            return response()->json([
                'canReport' => $canReport,
                'remainingTime' => $remainingTime,
                'lastReport' => $lastReport ? \Carbon\Carbon::parse($lastReport)->toDateTimeString() : null,
                'nextReport' => $lastReport ? \Carbon\Carbon::parse($lastReport)->addMinutes(2)->toDateTimeString() : null
            ]);
        });

        // Panduan
        Route::get('/masyarakat/panduan', function () {
            return view('Dashboardstlhlogin.masyarakat.PanduanMasyarakat');
        })->name('masyarakat.panduan');

        // Aktivitas
        Route::get('/masyarakat/aktivitas', function () {
            return view('Dashboardstlhlogin.masyarakat.AktivitasMasyarakat');
        })->name('masyarakat.aktivitas');

        Route::get('/masyarakat/aktivitas/LaporanSaya', [LaporanPengaduanController::class, 'laporanSayaMasyarakat'])->name('masyarakat.aktivitas.laporan.saya');

        Route::get('/masyarakat/aktivitas/LaporanWarga', [LaporanPengaduanController::class, 'laporanWargaMasyarakat'])->name('masyarakat.laporan.warga');

        Route::get('/masyarakat/aktivitas/StatistikDinas', [LaporanPengaduanController::class, 'statistikPemerintahMasyarakat'])->name('masyarakat.aktivitas.statistik');

        Route::get('/masyarakat/trackinglaporan/LaporanUlasan', function () {
            return view('Dashboardstlhlogin.masyarakat.trackinglaporan.LaporanUlasan');
        })->name('masyarakat.aktivitas');

        // Form kirim ulasan (POST)
        Route::post('/masyarakat/laporan/{id}/ulasan', [LaporanPengaduanController::class, 'kirimUlasan'])->name('masyarakat.laporan.kirimUlasan');

        // Komentar dan Like
        Route::post('/masyarakat/laporan/{id}/komentar', [LaporanPengaduanController::class, 'storeKomentar'])->name('masyarakat.laporan.komentar');
        Route::post('/masyarakat/laporan/{id}/like', [LaporanPengaduanController::class, 'storeLike'])->name('masyarakat.laporan.like');

        // Lihat ulasan publik
        Route::get('/masyarakat/laporan/ulasan/{id}', [LaporanPengaduanController::class, 'lihatUlasan'])->name('masyarakat.laporan.ulasan');

        // Profile Routes
        Route::middleware(['auth'])->group(function () {
        Route::get('/masyarakat/profil', function () {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }
            $user = Auth::user();
            return view('Dashboardstlhlogin.masyarakat.profilmasyarakat.ProfilMasyarakat', compact('user'));
        })->name('masyarakat.profil');

        Route::get('/masyarakat/profil/ubah', function () {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }
            $user = Auth::user();
            return view('Dashboardstlhlogin.masyarakat.profilmasyarakat.ubahprofile', compact('user'));
        })->name('masyarakat.profil.ubah');

        Route::put('/masyarakat/profil/update', [MasyarakatController::class, 'updateProfile'])->name('masyarakat.profil.update');
    });

        // Notifikasi
        Route::get('/masyarakat/notifikasi', [LaporanPengaduanController::class, 'notifikasiMasyarakat'])->name('masyarakat.notifikasi');
        Route::get('/masyarakat/notifikasi/{id}/detail', [LaporanPengaduanController::class, 'detailNotifikasiMasyarakatDitolak'])->name('masyarakat.notifikasi.laporan.ditolak');

        // Tracking Laporan
        Route::get('/masyarakat/laporan/menunggu/{id}', [LaporanPengaduanController::class, 'showTrackingMenunggu'])->name('masyarakat.laporan.menunggu');
        Route::get('/masyarakat/laporan/proses/ditindaklanjuti/{id}', [LaporanPengaduanController::class, 'showTrackingProsesDitindaklanjuti'])->name('masyarakat.laporan.proses.ditindaklanjuti');
        Route::get('/masyarakat/laporan/proses/diselesaikan/{id}', [LaporanPengaduanController::class, 'showTrackingProsesDiselesaikan'])->name('masyarakat.laporan.proses.diselesaikan');
        Route::get('/masyarakat/laporan/selesai/{id}', [LaporanPengaduanController::class, 'showTrackingSelesai'])->name('masyarakat.laporan.selesai');
        Route::get('/masyarakat/laporan/ditolak/{id}', [LaporanPengaduanController::class, 'showTrackingDitolak'])->name('masyarakat.laporan.ditolak');

        Route::get('/masyarakat/laporan/detail/{id}', [LaporanPengaduanController::class, 'detailLaporanMasyarakat'])->name('masyarakat.laporan.detail');
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/admin/laporan', [LaporanPengaduanController::class, 'indexLaporanAdmin'])->name('admin.laporan');

        Route::get('/admin/laporan/detail/{id}', [LaporanPengaduanController::class, 'adminDetailLaporan'])->name('admin.laporan.detail');

        Route::get('/admin/laporan/selesai/{id}', [LaporanPengaduanController::class, 'adminDetailLaporanSelesai'])->name('admin.laporan.selesai');

        Route::get('/admin/laporan/ditolak/{id}', [LaporanPengaduanController::class, 'adminDetailLaporanDitolak'])->name('admin.laporan.ditolak');

        Route::get('/admin/notifikasi', [LaporanPengaduanController::class, 'notifikasiAdmin'])->name('admin.notifikasi');
        Route::get('/admin/notifikasi/{id}/detail', [LaporanPengaduanController::class, 'detailNotifikasiLaporanDitolak'])->name('admin.notifikasi.ditolak');

        // Akun routes
        Route::get('/admin/akun', [App\Http\Controllers\AkunController::class, 'index'])->name('admin.akun');
        Route::get('/admin/akun/dinas', [App\Http\Controllers\DinasController::class, 'create'])->name('admin.akun.dinas');
        Route::post('/admin/akun/dinas', [App\Http\Controllers\DinasController::class, 'store'])->name('admin.akun.dinas.store');
        Route::get('/admin/akun/pusat', [App\Http\Controllers\PusatController::class, 'create'])->name('admin.akun.pusat');
        Route::post('/admin/akun/pusat', [App\Http\Controllers\PusatController::class, 'store'])->name('admin.akun.pusat.store');

        Route::post('/admin/laporan/verifikasi/{id}', [LaporanPengaduanController::class, 'adminVerifikasiLaporan'])->name('admin.laporan.verifikasi');
        Route::post('/admin/laporan/{id}/tolak', [LaporanPengaduanController::class, 'adminTolakLaporan'])->name('admin.laporan.tolak');

        Route::get('/admin/statistikDinas', function () {
            $dinasList = \App\Models\Dinas::all();
            $ditolakCount = \App\Models\LaporanPengaduan::where('status', 'Ditolak')->count();
            $selesaiCount = \App\Models\LaporanPengaduan::where('status', 'Selesai')->count();
            $prosesCount = \App\Models\LaporanPengaduan::where('status', 'Di Proses')->count();
            return view('Dashboardstlhlogin.Admin.StatistikDinas', compact('dinasList', 'ditolakCount', 'selesaiCount', 'prosesCount'));
        })->name('admin.statistikDinas');

        // Edit Akun Dinas
        Route::get('/admin/akun/dinas/{id}/edit', [App\Http\Controllers\DinasController::class, 'edit'])->name('admin.akun.dinas.edit');
        Route::post('/admin/akun/dinas/{id}/update', [App\Http\Controllers\DinasController::class, 'update'])->name('admin.akun.dinas.update');
        // Edit Akun Pusat
        Route::get('/admin/akun/pusat/{id}/edit', [App\Http\Controllers\PusatController::class, 'edit'])->name('admin.akun.pusat.edit');
        Route::post('/admin/akun/pusat/{id}/update', [App\Http\Controllers\PusatController::class, 'update'])->name('admin.akun.pusat.update');
    });

    // Dinas Routes
    Route::middleware('role:dinas')->group(function () {
        Route::get('/dinas/dashboard', function () {
            return view('Dashboardstlhlogin.Dinas.DasboardDinas');
        })->name('dinas.dashboard');

        Route::get('/dinas/laporan/masyarakat', [LaporanPengaduanController::class, 'laporanUtamaDinas'])->name('dinas.laporan.masyarakat');

        Route::get('/dinas/statistik', function () {
            $dinasList = \App\Models\Dinas::all(); // Ambil semua data dinas (untuk tabel)

            // Ambil user dinas yang sedang login dan model Dinas terkait
            $user = Auth::user();
            $dinasUser = $user->dinas()->first(); // Ambil model Dinas terkait user

            \Log::info('Checking dinasUser in statistik route', ['user_id' => $user->id, 'dinasUser_id' => $dinasUser ? $dinasUser->id : null, 'dinasUser_exists' => !is_null($dinasUser)]);

            $ditolakCount = 0;
            $selesaiCount = 0;
            $prosesCount = 0;

            if ($dinasUser) {
                // Hitung laporan Selesai, Di Proses, dan Ditolak untuk dinas yang sedang login
                $ditolakCount = \App\Models\LaporanPengaduan::where('dinas_id', $dinasUser->id)
                                ->where('status', 'Ditolak')
                                ->count();

                $selesaiCount = \App\Models\LaporanPengaduan::where('dinas_id', $dinasUser->id)
                                ->where('status', 'Selesai')
                                ->count();

                $prosesCount = \App\Models\LaporanPengaduan::where('dinas_id', $dinasUser->id)
                                ->where('status', 'Di Proses')
                                ->count();

                \Log::info('Statistik Dinas Count (Filter Dinas ID)', [
                    'dinas_id' => $dinasUser->id,
                    'ditolak' => $ditolakCount,
                    'selesai' => $selesaiCount,
                    'proses', $prosesCount,
                ]);

            } else {
                 \Log::warning('dinasUser not found for logged in user', ['user_id' => $user->id]);
            }

            // Lewatkan data dinasList (untuk tabel) dan counts (untuk chart) ke view
            return view('Dashboardstlhlogin.Dinas.AktivitasDinas.StatistikDinas', compact('dinasList', 'ditolakCount', 'selesaiCount', 'prosesCount'));
        })->name('dinas.statistik');

        Route::get('/dinas/notifikasi', [LaporanPengaduanController::class, 'notifikasiDinas'])->name('dinas.notifikasi');
        Route::get('/dinas/notifikasi/{id}/detail', [LaporanPengaduanController::class, 'detailNotifikasiDinasDitolak'])->name('dinas.notifikasi.ditolak');

        // Tracking Dinas
        Route::get('/dinas/laporan/step1', function () {
            return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep1');
        })->name('dinas.laporan.step1');

        Route::get('/dinas/laporan/step2/ditolak/{id}', [LaporanPengaduanController::class, 'showStep2Ditolak'])->name('dinas.laporan.step2.ditolak');

        Route::get('/dinas/laporan/step4/diproses/{id}', [LaporanPengaduanController::class, 'step4Diproses'])
            ->name('dinas.laporan.step4.diproses');

        Route::get('/dinas/laporan/step5/foto/{id}', [DinasController::class, 'step5Foto'])->name('dinas.laporan.step5.foto');

        Route::post('/dinas/laporan/{id}/upload-foto-penyelesaian', [DinasController::class, 'uploadFotoPenyelesaian'])->name('dinas.laporan.uploadFotoPenyelesaian');

        Route::get('/dinas/laporan/step6/hasil-foto/{id}', [DinasController::class, 'hasilFoto'])->name('dinas.laporan.hasilFoto');

        Route::get('/dinas/laporan/step7/validasi/{id}', [App\Http\Controllers\LaporanPengaduanController::class, 'step7Validasi'])
            ->name('dinas.laporan.step7.validasi');

        Route::get('/dinas/laporan/step8/selesai/{id}', [LaporanPengaduanController::class, 'dinasDetailLaporanSelesai'])->name('dinas.laporan.selesai');

        Route::get('/dinas/laporan/step9/ditolak/{id}', [LaporanPengaduanController::class, 'dinasStep9Ditolak'])->name('dinas.laporan.step9.ditolak');

        Route::post('/dinas/laporan/{id}/update-status', [LaporanPengaduanController::class, 'updateStatus'])->name('dinas.laporan.updateStatus');
        Route::post('/dinas/laporan/{id}/tindaklanjuti', [LaporanPengaduanController::class, 'tindaklanjutiLaporan'])->name('dinas.laporan.tindaklanjuti');

        // Untuk menampilkan laporan utama di dinas
        Route::get('/dinas/laporan/masyarakat', [LaporanPengaduanController::class, 'laporanUtamaDinas'])->name('dinas.laporan.masyarakat');

        Route::get('/dinas/laporan/detail/{id}', [LaporanPengaduanController::class, 'detailLaporanDinas'])->name('dinas.laporan.detail');

        Route::post('/dinas/laporan/{id}/penyelesaian', [LaporanPengaduanController::class, 'storePenyelesaian'])->name('dinas.laporan.penyelesaian');
        Route::get('/dinas/laporan/{id}/lanjutan', [LaporanPengaduanController::class, 'lanjutan'])->name('dinas.laporan.lanjutan');

        // Route untuk halaman lanjutan (step 7)
        Route::get('/dinas/laporan/step7/lanjutan/{id}', [LaporanPengaduanController::class, 'step7Lanjutan'])
            ->name('dinas.laporan.step7.lanjutan');

        Route::post('/dinas/laporan/{id}/selesaikan', [LaporanPengaduanController::class, 'selesaikanLaporan'])->name('dinas.laporan.selesaikan');

        // Route untuk aksi selesaikan laporan (step 6)
        Route::post('/dinas/laporan/{id}/selesaikan-step6', [LaporanPengaduanController::class, 'selesaikanStep6'])
            ->name('dinas.laporan.selesaikanStep6');

        Route::post('/dinas/laporan/{id}/tolak', [LaporanPengaduanController::class, 'tolakLaporan'])->name('dinas.laporan.tolak');
    });

    // Pemerintah Pusat Routes
    Route::middleware(['auth', 'role:pemerintahpusat'])->group(function () {
        Route::get('/pemerintahpusat/dashboard', [App\Http\Controllers\PusatController::class, 'dashboard'])->name('pemerintahpusat.dashboard');
        Route::get('/pemerintahpusat/statistikDinas', function () {
            return view('Dashboardstlhlogin.pemerintahpusat.StatistikDinas.statistikDinas');
        })->name('pemerintahpusat.statistikDinas');
        Route::get('/pemerintahpusat/laporan', [App\Http\Controllers\PusatController::class, 'laporanPusat'])->name('pemerintahpusat.laporan');
        Route::get('/pemerintahpusat/laporan/belumdirespon', function () {
            return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumdirespon.belumdirespon');
        })->name('pemerintahpusat.laporan.belumdirespon');
        Route::get('/pemerintahpusat/laporan/belum-terselesaikan', function () {
            return view('Dashboardstlhlogin.pemerintahpusat.LaporanBelumterselesaikan.laporan-belumterselesaikan');
        })->name('pemerintahpusat.laporan.belum-terselesaikan');
        Route::get('/pemerintahpusat/notifikasi', [LaporanPengaduanController::class, 'notifikasiPusat'])->name('pemerintahpusat.notifikasi');
        Route::get('/pemerintahpusat/notifikasi/{id}/detail', [LaporanPengaduanController::class, 'detailNotifikasiPusatDitolak'])->name('pemerintahpusat.notifikasi.ditolak');
    });

    // Untuk pusat melihat laporan yang belum direspon dinas
    Route::get('/pemerintahpusat/laporan', [\App\Http\Controllers\LaporanPengaduanController::class, 'laporanPusat'])->name('pemerintahpusat.laporan');

    // Akun routes
    Route::get('/admin/akun', [App\Http\Controllers\AkunController::class, 'index'])->name('admin.akun');
    Route::get('/admin/akun/dinas', [App\Http\Controllers\DinasController::class, 'create'])->name('admin.akun.dinas');
    Route::post('/admin/akun/dinas', [App\Http\Controllers\DinasController::class, 'store'])->name('admin.akun.dinas.store');
    Route::get('/admin/akun/pusat', [App\Http\Controllers\PusatController::class, 'create'])->name('admin.akun.pusat');
    Route::post('/admin/akun/pusat', [App\Http\Controllers\PusatController::class, 'store'])->name('admin.akun.pusat.store');
});

Route::get('/api/laporan-pengaduan', [LaporanPengaduanController::class, 'getAllLaporan']);

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Admin Protected Routes
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('Dashboardstlhlogin.Admin.Dashboard');
//     })->name('admin.dashboard');
// });

Route::post('/notifikasi/{id}/dismiss', [LaporanPengaduanController::class, 'dismissNotif'])->name('notifikasi.dismiss');
Route::post('/notifikasi/{id}/read', [LaporanPengaduanController::class, 'readNotif'])->name('notifikasi.read');

// Untuk testing/manual trigger eskalasi
Route::get('/escalate-laporan', [LaporanPengaduanController::class, 'escalateUnfinishedLaporan'])->name('laporan.escalate');

// Untuk pusat melihat laporan yang belum direspon dinas
Route::get('/pemerintahpusat/laporan/belum-direspon', [PusatController::class, 'laporanBelumRespon'])->name('pemerintahpusat.laporan.belum-direspon');

// Route detail laporan pusat yang belum direspon
Route::get('/pemerintahpusat/laporan/belum-direspon/{id}', [App\Http\Controllers\LaporanPengaduanController::class, 'detailBelumResponPusat'])->name('pemerintahpusat.laporan.belumdirespon.detail');

// Kirim notifikasi dari pusat ke dinas
Route::post('/pemerintahpusat/laporan/belum-direspon/{id}/kirim-pesan', [LaporanPengaduanController::class, 'kirimPesanPusatKeDinas'])->name('pemerintahpusat.laporan.kirimPesan');

// Halaman detail pesan pusat (untuk pusat)
Route::get('/pemerintahpusat/laporan/belum-direspon/pesan/{id}', [LaporanPengaduanController::class, 'pesanBelumDiresponPusat'])->name('pemerintahpusat.laporan.pesanBelumDirespon');

// Halaman detail pesan pusat (untuk dinas)
Route::get('/dinas/laporan/pesan-belum-direspon/{id}', [LaporanPengaduanController::class, 'pesanBelumDiresponDinas'])->name('dinas.laporan.pesanBelumDirespon');

Route::get('/escalate-unfinished', [LaporanPengaduanController::class, 'escalateUnfinishedLaporan']);

Route::get('/escalate-menunggu', [LaporanPengaduanController::class, 'escalateMenungguLaporan']);


// Route untuk laporan belum terselesaikan
Route::get('/pemerintahpusat/laporan/belumterselesaikan/{id}', [LaporanPengaduanController::class, 'laporanBelumTerselesaikan'])
    ->name('pemerintahpusat.laporan.belumterselesaikan.detail');

Route::post('/pemerintahpusat/laporan/belum-terselesaikan/{id}/kirim-pesan', [LaporanPengaduanController::class, 'kirimPesanBelumTerselesaikan'])
    ->name('pemerintahpusat.laporan.kirimPesanBelumTerselesaikan');

// Route untuk menampilkan detail pesan
Route::get('/pemerintahpusat/laporan/belum-terselesaikan/pesan/{id}', [LaporanPengaduanController::class, 'pesanBelumTerselesaikanPusat'])
    ->name('pemerintahpusat.laporan.pesanBelumTerselesaikan');

// Halaman detail pesan pusat (untuk dinas)
Route::get('/dinas/laporan/pesan-tidak-terselesaikan/{id}', [LaporanPengaduanController::class, 'pesanTidakTerselesaikanDinas'])->name('dinas.laporan.pesanTidakTerselesaikan');

Route::get('/debug-escalate', [\App\Http\Controllers\LaporanPengaduanController::class, 'escalateUnfinishedLaporan']);

// API untuk marker dinas
Route::get('/api/marker-dinas', function() {
    $dinas = \App\Models\Dinas::first();
    return response()->json($dinas);
});

// API untuk marker pusat
Route::get('/api/marker-pusat', function() {
    $pusat = \App\Models\PemerintahPusatDinas::first();
    return response()->json($pusat);
});
