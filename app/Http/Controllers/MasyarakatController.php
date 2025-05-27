<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MasyarakatController extends Controller
{
    public function createMasyarakatRecord(User $user)
    {
        // Get the latest masyarakat record to generate new ID
        $latest = Masyarakat::latest()->first();
        $newID = 'MSY' . str_pad(($latest ? $latest->id + 1 : 1), 3, '0', STR_PAD_LEFT);

        // Create new masyarakat record
        Masyarakat::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'masyarakat_id' => $newID,
            'poin' => 0
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $masyarakat = $user->masyarakat;

        // Debug log the request
        Log::info('Profile update request received', [
            'has_file' => $request->hasFile('foto_profil'),
            'all_data' => $request->all(),
            'user_id' => $user->id,
            'masyarakat_id' => $masyarakat->id
        ]);

        // Validate the request
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto_profil.max' => 'Ukuran foto maksimal 2 MB.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto harus jpeg, png, atau jpg.',
        ]);
        Log::info('Validation passed', ['validated_data' => $validated]);

        try {
            DB::beginTransaction();

            // Update user data
            $userData = [
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
                'username' => $request->username,
            ];
            $user->update($userData);

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            // Update masyarakat data
            $masyarakatData = [
                'username' => $request->username,
            ];
            // Handle file upload
            if ($request->hasFile('foto_profil')) {
                $image = file_get_contents($request->file('foto_profil')->getRealPath());
                $masyarakatData['foto_profil'] = $image;
            }
            $masyarakat->update($masyarakatData);

            DB::commit();
            Log::info('Profile updated successfully');
            return redirect()->route('masyarakat.profil')->with('success', 'Update berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}