<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        Log::info('GOOGLE CALLBACK HIT');

        try {
            // 1. Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            Log::info('GOOGLE USER DATA', [
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId()
            ]);

            // 2. Cek apakah user dengan email ini sudah ada di database?
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // KASUS A: User sudah ada (Mungkin register manual sebelumnya)
                Log::info('USER FOUND, LINKING ACCOUNT...');
                
                // Update google_id jika belum ada, dan update avatar
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    // Opsional: update email_verified_at jika null
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // KASUS B: User benar-benar baru
                Log::info('USER NOT FOUND, CREATING NEW...');

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'user', // Set default role
                    'email_verified_at' => now(),
                    // Kita buat password random agar tidak error di database
                    'password' => Hash::make(Str::random(24)), 
                ]);
            }

            // 3. Login User
            Auth::login($user);

            // 4. Redirect ke Dashboard
            return redirect()->intended('dashboard');

        } catch (\Throwable $e) {
            Log::error('GOOGLE LOGIN FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}