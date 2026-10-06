<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use Symfony\Component\HttpFoundation\Response;

class EnsureContractSigned
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek jika dia guru dan profilnya ada
        if ($user && $user->role === 'teacher' && $user->teacherProfile) {
            
            // Jika guru BELUM setuju kontrak
            if (!$user->teacherProfile->is_contract_signed) {
                
                // Izinkan akses hanya ke halaman Profil dan Logout (agar tidak error / loop)
                $allowedRoutes = [
                    'filament.teacher.auth.profile',
                    'filament.teacher.auth.logout',
                ];

                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    
                    // Beri peringatan
                    Notification::make()
                        ->warning()
                        ->title('Akses Terkunci!')
                        ->body('Anda wajib menyetujui Lembar Kesepakatan Kerja sebelum mengakses jadwal atau fitur lainnya.')
                        ->send();

                    // Tendang kembali ke halaman profil
                    return redirect()->route('filament.teacher.auth.profile');
                }
            }
        }

        return $next($request);
    }
}