<?php

namespace App\Filament\Teacher\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Form; // Wajib untuk form builder
use Afatmustafa\FilamentTurnstile\Forms\Components\Turnstile; // Wajib untuk Turnstile

class TeacherLogin extends BaseLogin
{
    // =========================================================================
    // [BARU] MENGARAHKAN HALAMAN KE DESAIN CUSTOM KITA SENDIRI
    // =========================================================================
    protected static string $view = 'filament.teacher.pages.login';

    // 1. Mengubah judul utama (Sign in)
    public function getHeading(): string | Htmlable
    {
        return 'Portal Pengajar';
    }

    // 2. Menambahkan teks sub-judul deskripsi
    public function getSubheading(): string | Htmlable
    {
        return 'Silakan masuk untuk mengelola jadwal, santri, dan laporan hafalan di Deep Quran Academy.';
    }

    // 3. Menambahkan Form input + Widget Turnstile
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

                // Widget Turnstile (Ditengahkan dengan sempurna)
                Turnstile::make('turnstile')
                    ->hiddenLabel() 
                    ->theme('light')
                    ->extraFieldWrapperAttributes([
                        'class' => 'flex justify-center w-full mt-2'
                    ]),
            ])
            ->statePath('data');
    }
}