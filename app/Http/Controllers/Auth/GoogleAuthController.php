<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        \Log::info('GOOGLE CALLBACK HIT'); // debug

        try {
            $googleUser = Socialite::driver('google')->user();

            \Log::info('GOOGLE USER', [
                'id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
            ]);

            $user = \App\Models\User::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'role' => 'user',
                ]
            );

            \Log::info('USER CREATED/UPDATED', $user->toArray());

            \Illuminate\Support\Facades\Auth::login($user);

            return redirect('/dashboard')->with('status', 'Login Google berhasil');
        } catch (\Throwable $e) {
            \Log::error('GOOGLE ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect('/login')->with('error', 'Login Google gagal: '.$e->getMessage());
        }
    }
}
