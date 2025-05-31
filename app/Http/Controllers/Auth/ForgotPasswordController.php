<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            // Generate OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store OTP in database
            PasswordResetToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => $otp,
                    'expires_at' => Carbon::now()->addMinutes(5), // Sesuai kode Anda (5 menit)
                ]
            );

            Log::info('Attempting to send OTP email', [
                'email' => $request->email,
                'otp' => $otp,
            ]);

            // Send OTP via email
            Mail::to($request->email)->send(new OTPMail($otp));

            Log::info('OTP sent successfully', [
                'email' => $request->email,
                'timestamp' => now(),
            ]);

            return redirect()->route('otp.form', ['email' => $request->email])
                ->with('message', 'Kode OTP telah dikirim ke email Anda.');

        } catch (Exception $e) {
            Log::error('Failed to send OTP email', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'email' => 'Gagal mengirim kode OTP. Silakan coba lagi nanti.',
            ]);
        }
    }

    public function showOTPForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi telah berakhir. Silakan minta OTP baru.']);
        }
        return view('auth.kode-otp', compact('email'));
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email|exists:users,email',
        ]);

        $passwordReset = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau telah kedaluwarsa.']);
        }

        // Generate reset token
        $token = Str::random(64);
        $passwordReset->update(['token' => $token]);

        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function resendOTP(Request $request)
    {
        $email = $request->email;
        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi telah berakhir. Silakan minta OTP baru.']);
        }

        // Batasan pengiriman ulang OTP (maksimum 3 kali per jam)
        $recentTokens = PasswordResetToken::where('email', $email)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->count();

        if ($recentTokens >= 3) {
            return back()->withErrors(['email' => 'Terlalu banyak permintaan OTP. Silakan coba lagi nanti.']);
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in database
        PasswordResetToken::updateOrCreate(
            ['email' => $email],
            [
                'token' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]
        );

        // Send OTP via email
        Mail::to($email)->send(new OTPMail($otp));

        return back()->with('message', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        $passwordReset = PasswordResetToken::where('email', $email)
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Link reset password tidak valid atau telah kedaluwarsa.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $passwordReset = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token tidak valid atau telah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->setRememberToken(Str::random(60));

        $user->save();

        // Hapus token setelah reset
        $passwordReset->delete();

        return redirect()->route('login')
            ->with('message', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}