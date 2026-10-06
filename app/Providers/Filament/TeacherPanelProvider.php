<?php

namespace App\Providers\Filament;

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

// 1. Import Class Halaman Profil Custom
use App\Filament\Pages\EditProfile;

// [BARU] Import Class Custom Login yang baru dibuat
use App\Filament\Teacher\Pages\Auth\TeacherLogin;

// [BARU] Import Class untuk Hooks Filament (PWA)
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class TeacherPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher')
            ->path('teacher')
            ->brandName('Deep Quran Academy')
            ->favicon(asset('images/pavicon.png'))
            ->brandLogo(asset('images/d6.png'))
            ->brandLogoHeight('4rem')

            // =========================================================
            // 🔥 [BARU] MATIKAN DARK MODE SECARA PERMANEN
            // =========================================================
            ->darkMode(false)
            // =========================================================

            // [PERBAIKAN DI SINI] Masukkan class kustom ke dalam method login()
            ->login(TeacherLogin::class)

            ->profile(EditProfile::class)

            // =========================================================
            // 🔥 [BARU] AKTIFKAN LONCENG NOTIFIKASI DI DASHBOARD GURU
            // =========================================================
            ->databaseNotifications()
            // =========================================================

            ->colors([
                'primary' => Color::Green,
                'gray' => Color::Gray,
            ])

            ->discoverResources(in: app_path('Filament/Teacher/Resources'), for: 'App\\Filament\\Teacher\\Resources')
            ->discoverPages(in: app_path('Filament/Teacher/Pages'), for: 'App\\Filament\\Teacher\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Teacher/Widgets'), for: 'App\\Filament\\Teacher\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
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
                \App\Http\Middleware\EnsureContractSigned::class,
            ])
            // ==============================================================
            // [BARU] 1. INJEKSI MANIFEST & META PWA KE DALAM <HEAD> FILAMENT
            // ==============================================================
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('
                    <link rel="manifest" href="/manifest-teacher.json">
                    <meta name="theme-color" content="#15803d">
                    <link rel="apple-touch-icon" href="/images/pavicon.png">
                    <meta name="apple-mobile-web-app-capable" content="yes">
                    <meta name="apple-mobile-web-app-status-bar-style" content="default">
                ')
            )
            // ==============================================================
            // [BARU] 2. INJEKSI SERVICE WORKER & POP-UP INSTALL KE BAWAH HALAMAN
            // ==============================================================
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('
                    <script>
                        if ("serviceWorker" in navigator) {
                            window.addEventListener("load", () => {
                                navigator.serviceWorker.register("/sw.js")
                                    .then(reg => console.log("PWA Guru terdaftar!"))
                                    .catch(err => console.log("PWA gagal:", err));
                            });
                        }
                    </script>

                    <div id="pwa-custom-popup" style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: calc(100% - 40px); max-width: 380px; background: white; padding: 20px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 999999; font-family: sans-serif; border: 1px solid #e5e7eb; box-sizing: border-box;">
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <img src="/images/pavicon.png" style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
                            <div>
                                <h3 style="margin: 0; font-size: 15px; font-weight: bold; color: #111827;">Install Portal Guru</h3>
                                <p style="margin: 5px 0 15px 0; font-size: 12px; color: #6b7280; line-height: 1.4;">Akses jadwal dan isi jurnal absensi lebih cepat langsung dari layar utama Anda.</p>
                                <div style="display: flex; gap: 8px;">
                                    <button id="btn-install-pwa" style="background: #16a34a; color: white; border: none; padding: 8px 10px; border-radius: 8px; font-weight: bold; font-size: 12px; cursor: pointer; flex: 1;">Install Sekarang</button>
                                    <button id="btn-close-pwa" style="background: #f3f4f6; color: #4b5563; border: none; padding: 8px 10px; border-radius: 8px; font-weight: bold; font-size: 12px; cursor: pointer; flex: 1;">Nanti Saja</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        let pwaPrompt;
                        const pwaPopup = document.getElementById("pwa-custom-popup");
                        const btnInstall = document.getElementById("btn-install-pwa");
                        const btnClose = document.getElementById("btn-close-pwa");

                        window.addEventListener("beforeinstallprompt", (e) => {
                            e.preventDefault();
                            pwaPrompt = e;
                            pwaPopup.style.display = "block"; 
                        });

                        btnInstall.addEventListener("click", async () => {
                            if (pwaPrompt) {
                                pwaPrompt.prompt();
                                const { outcome } = await pwaPrompt.userChoice;
                                pwaPrompt = null;
                                pwaPopup.style.display = "none";
                            }
                        });

                        btnClose.addEventListener("click", () => {
                            pwaPopup.style.display = "none";
                        });

                        window.addEventListener("appinstalled", () => {
                            pwaPopup.style.display = "none";
                            console.log("Aplikasi Guru Berhasil Diinstal");
                        });
                    </script>
                ')
            );
    }
}