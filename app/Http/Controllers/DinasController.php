<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dinas;
use App\Models\LaporanPengaduan;
use App\Models\PenyelesaianLaporan; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DinasController extends Controller
{
    public function create()
    {
        return view('Dashboardstlhlogin.Admin.Akun.BuatAkunDinas');
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Dinas creation request data:', [
            'all_data' => $request->all(),
            'has_file' => $request->hasFile('polygon_wilayah'),
            'file_info' => $request->hasFile('polygon_wilayah') ? [
                'name' => $request->file('polygon_wilayah')->getClientOriginalName(),
                'size' => $request->file('polygon_wilayah')->getSize(),
                'mime' => $request->file('polygon_wilayah')->getMimeType(),
            ] : null
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username|unique:dinas,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nomor_telepon' => 'required|string|max:15',
            'wilayah' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nik' => 'nullable|prohibited' // memastikan NIK tidak diisi
        ]);

        if ($validator->fails()) {
            // Log validation errors
            Log::error('Validation failed:', [
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->all(),
                'file_info' => $request->hasFile('polygon_wilayah') ? [
                    'name' => $request->file('polygon_wilayah')->getClientOriginalName(),
                    'size' => $request->file('polygon_wilayah')->getSize(),
                    'mime' => $request->file('polygon_wilayah')->getMimeType(),
                ] : null
            ]);

            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->messages()
            ], 422);
        }

        try {
            // Upload foto profil jika ada
            $fotoProfilPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoProfilPath = $request->file('foto_profil')->store('foto_profil_dinas', 'public');
            }

            // Create user
            $user = User::create([
                'nama_lengkap' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nomor_telepon' => $request->nomor_telepon,
                'role' => 'dinas',
                'nik' => null // Memastikan NIK null
            ]);

            // Create dinas record
            $dinas = Dinas::create([
                'user_id' => $user->id,
                'username' => $request->username,
                'wilayah' => $request->wilayah,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'grade' => 'A', // Default grade
                'point' => 0, // Default point
                'foto_profil' => $fotoProfilPath,
            ]);

            // Get laporan utama
            $laporanUtama = LaporanPengaduan::whereNull('related_pengaduan_id')->where('dinas_id', $dinas->id)->get();

            return redirect()->route('admin.akun')->with('success', 'Akun dinas berhasil dibuat!');

        } catch (\Exception $e) {
            Log::error('Error creating dinas account:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat akun',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function step5Foto($id)
    {
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep5Foto', compact('id'));
    }

    public function hasilFoto($id)
    {
        $laporan = \App\Models\LaporanPengaduan::with('tracking')->findOrFail($id);
        $penyelesaian = \App\Models\PenyelesaianLaporan::where('pengaduan_id', $id)->first();
        return view('Dashboardstlhlogin.Dinas.AktivitasDinas.TrackingDinas.DinasStep6HasilFoto', compact('laporan', 'penyelesaian'));
    }

    public function uploadFotoPenyelesaian(Request $request, $id)
    {
        $request->validate([
            'foto_penyelesaian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $penyelesaian = \App\Models\PenyelesaianLaporan::where('pengaduan_id', $id)->first();

        if (!$penyelesaian) {
            \Log::error('Penyelesaian tidak ditemukan untuk pengaduan_id: ' . $id);
            return response()->json(['success' => false, 'message' => 'Data penyelesaian tidak ditemukan.'], 404);
        }

        if ($request->hasFile('foto_penyelesaian')) {
            $file = $request->file('foto_penyelesaian');
            $path = $file->store('penyelesaian', 'public');
            $penyelesaian->foto_penyelesaian = $path;

            // Fix waktu_foto format
            if ($request->waktu_foto) {
                $waktuFoto = date('Y-m-d H:i:s', strtotime($request->waktu_foto));
                $penyelesaian->waktu_foto = $waktuFoto;
            } else {
                $penyelesaian->waktu_foto = now();
            }

            $penyelesaian->alamat_foto = $request->alamat_foto ?? null;

            if ($penyelesaian->save()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dinas.laporan.hasilFoto', $id)
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan ke database!'], 500);
            }
        }

        \Log::error('File tidak ditemukan di request.');
        return response()->json(['success' => false, 'message' => 'Gagal upload foto!'], 400);
    }

    public function edit($id)
    {
        $dinas = \App\Models\Dinas::where('user_id', $id)->firstOrFail();
        $user = \App\Models\User::findOrFail($id);
        return view('Dashboardstlhlogin.Admin.Akun.editAkunDinas', compact('dinas', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $dinas = \App\Models\Dinas::where('user_id', $id)->firstOrFail();

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nomor_telepon' => 'required|string|max:15',
            'wilayah' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'password' => 'nullable|string|min:8',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update user
        $user->nama_lengkap = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        if ($request->filled('password')) {
            $user->password = \Hash::make($request->password);
        }
        $user->save();

        // Update dinas
        $dinas->username = $request->username;
        $dinas->wilayah = $request->wilayah;
        $dinas->latitude = $request->latitude;
        $dinas->longitude = $request->longitude;
        if ($request->hasFile('foto_profil')) {
            $fotoProfilPath = $request->file('foto_profil')->store('foto_profil_dinas', 'public');
            $dinas->foto_profil = $fotoProfilPath;
        }
        $dinas->save();

        return redirect()->route('admin.akun')->with('success', 'Akun dinas berhasil diupdate.');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $dinas = \App\Models\Dinas::where('user_id', $user->id)->first();
        // Data lain untuk dashboard bisa ditambah di sini
        return view('Dashboardstlhlogin.Dinas.DasboardDinas', compact('dinas'));
    }
}