<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

// [BARU] Import untuk Kustomisasi Email Reset Password
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

// Import Facades Gate untuk mendaftarkan Policy
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // === [BARU] DAFTARKAN POLICY USER UNTUK KEAMANAN ADMIN ===
        // Menghubungkan Model User dengan UserPolicy yang baru Anda buat
        Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);

        // === LOGIKA DINAMIS (UPDATED) ===

        // 1. Cek apakah APP_URL di .env mengandung kata 'https' (Paling Akurat)
        // Karena di .env Anda tertulis https://app..., maka ini akan bernilai TRUE
        $isHttpsConfig = \Illuminate\Support\Str::contains(config('app.url'), 'https');

        // 2. Cek Header dari Cloudflare/Proxy
        $isCloudflare = request()->header('X-Forwarded-Proto') === 'https';

        // 3. Cek Environment Production
        $isProduction = $this->app->environment('production');

        // Jika SALAH SATU kondisi terpenuhi, paksa HTTPS
        if ($isHttpsConfig || $isCloudflare || $isProduction) {
            URL::forceScheme('https');
        }

        // === [BARU] KUSTOMISASI EMAIL RESET PASSWORD ===
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {

            // Generate link reset password
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Permintaan Reset Password - Deep Quran Academy')
                ->greeting('Assalamu\'alaikum, ' . $notifiable->name . '!')
                ->line('Anda menerima email ini karena kami menerima permintaan pengaturan ulang reset password untuk akun Anda.')
                ->action('Reset Password Sekarang', $url)
                ->line('Tautan reset password ini akan hangus dalam ' . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . ' menit.')
                ->line('Jika Anda tidak merasa meminta reset password, abaikan saja email ini. Akun Anda tetap aman.')
                ->salutation('Jazakumullah Khairan, Admin Deep Quran Academy');
        });
    }
}