<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        try {
            DB::beginTransaction();

            // Update data user
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nomor_telepon' => $request->nomor_telepon,
                    'email' => $request->email,
                    'username' => $request->username,
                ]);

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $request->validate([
                    'password' => ['required', 'confirmed', Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                    ],
                ]);

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'password' => Hash::make($request->password)
                    ]);
            }

            DB::commit();
            return redirect()->route('masyarakat.profil')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }
}