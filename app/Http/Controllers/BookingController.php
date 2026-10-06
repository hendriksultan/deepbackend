<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;
use App\Models\Booking;
use App\Models\User; // [BARU] Import model User untuk mencari Admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

// [BARU] Import fitur Notifikasi Filament
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class BookingController extends Controller
{
    public function create($teacher_id)
    {
        $teacher = TeacherProfile::with(['user', 'schedules' => function ($q) {
            $q->where('start', '>=', now()->startOfDay())
                ->orderBy('start', 'asc');
        }])->findOrFail($teacher_id);

        return view('booking', compact('teacher'));
    }

    public function store(Request $request, $teacher_id)
    {
        // 1. Validasi Input
        $request->validate([
            'student_name' => 'required|string|max:255',
            'email'        => 'required|email',
            'whatsapp'     => 'required|numeric',
            'program_type' => 'required',
            // Validasi Alamat (Wajib jika Offline)
            'student_address' => 'required_if:method,offline',
        ]);

        // 2. Simpan ke Database (Tampung di variabel $booking)
        $booking = Booking::create([
            'user_id'            => Auth::id(),
            'teacher_profile_id' => $teacher_id,
            'student_name'       => $request->student_name,
            'email'              => $request->email,
            'whatsapp'           => $request->whatsapp,
            'program_type'       => $request->program_type,
            'status'             => 'pending',

            // Data Penting yang sebelumnya hilang
            'method'          => $request->method,
            'student_address' => $request->student_address,
            'maps_link'       => $request->maps_link,
        ]);

        // --- [BARU] 3. KIRIM NOTIFIKASI KE ADMIN ---
        // Cari semua user yang memiliki akses Admin
        $admins = User::where('role', 'admin')->get();

        // Buat pesan notifikasi
        Notification::make()
            ->title('Pendaftaran Kursus Baru! 🎓')
            ->body("Santri baru atas nama **{$booking->student_name}** mendaftar program **{$booking->program_type}** ({$booking->method}).")
            ->success()
            ->icon('heroicon-o-academic-cap')
            ->actions([
                // Tombol ini akan mengarahkan admin ke halaman tabel Booking
                Action::make('view')
                    ->label('Lihat Pendaftaran')
                    ->url('/admin/bookings') // Sesuaikan dengan URL resource Booking di Filament Anda
                    ->button(),
            ])
            ->sendToDatabase($admins);
        // -------------------------------------------

        // [PERBAIKAN] Gunakan nama route yang benar: 'student.dashboard'
        return redirect()->route('student.dashboard')->with('success', 'Pendaftaran berhasil! Silakan upload bukti pembayaran.');
    }

    public function uploadPayment(Request $request, $booking_id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::findOrFail($booking_id);

        if ($request->hasFile('payment_proof')) {
            if ($booking->payment_proof) {
                Storage::disk('public')->delete($booking->payment_proof);
            }
            $path = $request->file('payment_proof')->store('payments', 'public');
            $booking->update([
                'payment_proof' => $path,
                'status'        => 'verifying',
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Admin akan segera memverifikasi.');
    }

    // ==========================================================
    // [BARU] FUNGSI UNTUK KONFIRMASI PROGRAM GRATIS
    // ==========================================================
    public function confirmFree($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Pastikan yang klik adalah pemilik pendaftaran yang sah
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        // Langsung ubah statusnya menjadi verifying (menunggu ACC Admin)
        $booking->update([
            'status' => 'verifying', 
        ]);

        return redirect()->back()->with('success', 'Alhamdulillah! Pendaftaran program gratis Anda berhasil dikonfirmasi dan sedang menunggu persetujuan Admin.');
    }
}