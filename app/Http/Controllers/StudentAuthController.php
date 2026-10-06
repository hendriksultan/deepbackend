<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Import class Http dan ValidationException untuk Turnstile
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

// Import Facade Mail dan Log untuk pengiriman email
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

// Import class Notifikasi dari Filament
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class StudentAuthController extends Controller
{
    /**
     * Menampilkan halaman login/register
     */
    public function showAuth()
    {
        if (Auth::check()) {
            // [PERBAIKAN] Cek jika role admin atau teacher, arahkan ke Panel Admin (Filament)
            if (in_array(Auth::user()->role, ['admin', 'teacher'])) {
                return redirect('/admin');
            }

            // Sisanya (student/santri) arahkan ke dashboard
            return redirect('/dashboard');
        }

        return view('auth.auth-page');
    }

    /**
     * Proses Registrasi Santri Baru
     */
    public function processRegister(Request $request)
    {
        // ==========================================================
        // 1. VALIDASI CLOUDFLARE TURNSTILE
        // ==========================================================
        $turnstileResponse = $request->input('cf-turnstile-response');

        $verify = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $turnstileResponse,
            'remoteip' => $request->ip(),
        ]);

        if (! $verify->json('success')) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Verifikasi keamanan gagal. Pastikan Anda bukan robot.',
            ]);
        }
        // ==========================================================

        // 2. VALIDASI INPUT
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // Validasi Checkbox Syarat & Ketentuan
            'terms'    => 'required|accepted',
        ], [
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
            'terms.accepted'     => 'Anda wajib menyetujui Syarat & Ketentuan untuk mendaftar.',
        ]);

        // 3. BUAT USER BARU
        $newUser = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'student',
            'is_verified' => false,
        ]);

        // 4. KIRIM NOTIFIKASI (DATABASE & EMAIL) KE SEMUA ADMIN
        $admins = User::where('role', 'admin')->get();

        // A. Notifikasi Internal (Filament Lonceng Database)
        Notification::make()
            ->title('Pendaftaran Santri Baru! 🎉')
            ->body('Ada santri baru mendaftar atas nama: **' . $newUser->name . '**. Segera lakukan verifikasi akun.')
            ->success()
            ->icon('heroicon-o-user-plus')
            ->actions([
                Action::make('view')
                    ->label('Verifikasi Santri')
                    ->url('/admin/users')
                    ->button(),
            ])
            ->sendToDatabase($admins);

        // B. [DIPERBARUI] Notifikasi via Email ke Admin (Kirim Satu per Satu)
        try {
            if ($admins->count() > 0) {
                $loginAdminUrl = url('/admin');
                $waktuDaftar = now()->format('d F Y, H:i') . ' WIB';

                $htmlMessage = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; background-color: #f9fafb;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #15803d; margin: 0;'>Pendaftar Baru! 🎉</h2>
                            <p style='color: #6b7280; font-size: 14px; margin-top: 5px;'>Sistem Deep Quran Academy</p>
                        </div>
                        
                        <div style='background-color: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;'>
                            <p>Assalamu'alaikum Tim Admin,</p>
                            <p>Alhamdulillah, ada pendaftar baru yang baru saja membuat akun di website. Berikut adalah rinciannya:</p>
                            
                            <table style='width: 100%; border-collapse: collapse; margin: 15px 0;'>
                                <tr>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6; width: 120px;'><strong>Nama</strong></td>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6;'>: {$newUser->name}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6;'><strong>Email</strong></td>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6;'>: {$newUser->email}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6;'><strong>Waktu</strong></td>
                                    <td style='padding: 8px 0; border-bottom: 1px solid #f3f4f6;'>: {$waktuDaftar}</td>
                                </tr>
                            </table>

                            <p>Status akun saat ini adalah <strong>Belum Diverifikasi</strong>. Silakan login ke Panel Admin untuk melihat detail lebih lanjut atau memverifikasi akun ini agar santri bisa login.</p>
                            
                            <div style='text-align: center; margin: 30px 0 10px 0;'>
                                <a href='{$loginAdminUrl}' style='background-color: #15803d; color: white; padding: 12px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Buka Panel Admin</a>
                            </div>
                        </div>
                    </div>
                ";

                // Kirim email SATU PER SATU ke masing-masing admin untuk menghindari penolakan sendmail
                foreach ($admins as $admin) {
                    if (filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                        Mail::html($htmlMessage, function ($message) use ($admin) {
                            $message->to($admin->email)
                                ->subject('🔔 Pendaftar Baru - Deep Quran Academy');
                        });
                    }
                }
            }
        } catch (\Exception $e) {
            // Blok try-catch digunakan agar jika email gagal terkirim (misal SMTP mati),
            // proses registrasi santri tetap berhasil tanpa error 500 di layarnya.
            Log::error('Gagal mengirim email notif admin pendaftaran baru: ' . $e->getMessage());
        }

        // 5. REDIRECT
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi admin. Silakan coba login berkala.');
    }

    /**
     * Proses Login (Admin & Santri)
     */
    public function processLogin(Request $request)
    {
        // ==========================================================
        // 1. VALIDASI CLOUDFLARE TURNSTILE
        // ==========================================================
        // Lewati Turnstile hanya untuk pengujian login di lingkungan lokal.
        if (! app()->environment('local')) {
            $turnstileResponse = $request->input('cf-turnstile-response');

            $verify = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => env('TURNSTILE_SECRET_KEY'),
                'response' => $turnstileResponse,
                'remoteip' => $request->ip(),
            ]);

            if (! $verify->json('success')) {
                throw ValidationException::withMessages([
                    'cf-turnstile-response' => 'Verifikasi keamanan gagal. Pastikan Anda bukan robot.',
                ]);
            }
        }
        // ==========================================================

        // 2. VALIDASI KREDENSIAL
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // [PERBAIKAN] Pastikan blokir login "belum verifikasi" HANYA berlaku untuk student/santri
            if (in_array($user->role, ['student', 'santri']) && !$user->is_verified) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi oleh admin. Mohon bersabar.'
                ]);
            }

            $request->session()->regenerate();

            // [PERBAIKAN] Arahkan Admin dan Teacher ke /admin
            if (in_array($user->role, ['admin', 'teacher'])) {
                return redirect()->intended('/admin');
            }

            // Student/Santri ke dashboard
            return redirect()->intended('/dashboard');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ]);
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
