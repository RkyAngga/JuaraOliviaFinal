<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan form lupa password
    public function showLinkRequestForm()
    {
        return view('auth.ForgotPassword');
    }

    // 2. Proses kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        PasswordResetOtp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Kirim email OTP
        Mail::raw("Kode OTP Anda: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Kode OTP Reset Password');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('otp.form')->with('message', 'Kode OTP telah dikirim ke email Anda.');
    }

    // 3. Tampilkan form OTP
    public function showOtpForm()
    {
        return view('auth.KodeOtp');
    }

    // 4. Proses verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $email = session('reset_email');
        $otpRecord = PasswordResetOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau kadaluarsa.']);
        }

        session(['otp_verified' => true]);
        return redirect()->route('password.reset.form');
    }

    // 5. Tampilkan form reset password
    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('otp.form')->withErrors(['otp' => 'Verifikasi OTP terlebih dahulu.']);
        }
        return view('auth.ResetPassword');
    }

    // 6. Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session & OTP
        session()->forget(['reset_email', 'otp_verified']);
        PasswordResetOtp::where('email', $email)->delete();

        return redirect()->route('login')->with('message', 'Password berhasil direset. Silakan login.');
    }
} 