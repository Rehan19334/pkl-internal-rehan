<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman OAuth Google
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless() // ⭐ PENTING: hindari masalah session OAuth
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function callback()
    {
        try {
            // ===============================
            // AMBIL DATA USER DARI GOOGLE
            // ===============================
            $googleUser = Socialite::driver('google')
                ->stateless() // ⭐ HARUS SAMA DENGAN redirect()
                ->user();

            // ===============================
            // CARI / BUAT USER
            // ===============================
            $user = $this->findOrCreateUser($googleUser);

            // ===============================
            // LOGIN USER (GUARD WEB)
            // ===============================
            // ✅ Gunakan loginUsingId untuk memastikan session tidak terganggu
            Auth::loginUsingId($user->id, true);

            // ===============================
            // REGENERATE SESSION
            // ===============================
            request()->session()->regenerate();

            // ===============================
            // REDIRECT KE HOME
            // ===============================
            return redirect()->route('home')
                ->with('success', 'Berhasil login dengan Google!');
        } catch (Exception $e) {
            // Log error supaya mudah debugging
            logger()->error('Google OAuth Error: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google.');
        }
    }

    /**
     * Cari user atau buat user baru
     */
    protected function findOrCreateUser($googleUser): User
    {
        // ===============================
        // 1. LOGIN VIA GOOGLE SEBELUMNYA
        // ===============================
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if ($googleUser->getAvatar() && $user->avatar !== $googleUser->getAvatar()) {
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
            return $user;
        }

        // ===============================
        // 2. EMAIL SUDAH ADA (REGISTER MANUAL)
        // ===============================
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar() ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            return $user;
        }

        // ===============================
        // 3. USER BARU
        // ===============================
        return User::create([
            'name'              => $googleUser->getName(),
            'email'             => $googleUser->getEmail(),
            'google_id'         => $googleUser->getId(),
            'avatar'            => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password'          => Hash::make(Str::random(32)),
            'role'              => 'customer', // default role customer
        ]);
    }
}
