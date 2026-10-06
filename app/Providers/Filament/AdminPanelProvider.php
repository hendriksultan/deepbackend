<?php

namespace App\Providers\Filament;

// --- [TAMBAHKAN BARIS INI] ---
use App\Filament\Pages\Auth\CustomLogin;
// ----------------------------
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// 1. IMPORT PLUGIN DI SINI
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->favicon(asset('images/pavicon.png'))
            ->brandName('Admin Deep Quran Academy')
            ->brandLogo(asset('images/d6.png')) // Pastikan file ada di public/images
            ->brandLogoHeight('4rem') // Mengatur tinggi logo
            ->login(CustomLogin::class)
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Gray,
            ])


            // --- [BARU] AKTIFKAN NOTIFIKASI LONCENG DI SINI ---
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s') // Cek notif baru tiap 30 detik
            // ---------------------------------------------------

            // 2. DAFTARKAN PLUGIN DI SINI
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->selectable() // Agar tanggal bisa diklik
                    ->editable()   // Agar jadwal bisa digeser (drag & drop)
            )
            // ---------------------------

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
