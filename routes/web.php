<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan; // Ditambahkan untuk eksekusi Artisan via URL

// --- MODELS ---
use App\Models\ContactMessage;
use App\Models\TeacherApplication;
use App\Models\User;
use App\Models\Booking;

// --- FILAMENT & NOTIFICATIONS ---
use Filament\Notifications\Notification;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\TeacherApplicationResource;

// --- CONTROLLERS ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\InfaqController;
use App\Http\Controllers\Student\QuranController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\DonationController;

use App\Models\Schedule;
use Carbon\Carbon;

// ==============================================================================
// 1. HALAMAN PUBLIK (BISA DIAKSES SIAPA SAJA)
// ==============================================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Statis Umum
Route::view('/tentang-kami', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/syarat-ketentuan', 'terms')->name('terms');
Route::view('/kebijakan-privasi', 'privacy')->name('privacy');

// [DIPERBARUI] Route Halaman Program
Route::view('/program/tahsin-dewasa', 'tahsin-dewasa')->name('program.tahsin-dewasa');
Route::view('/program/tahfidz-dewasa', 'tahfidz-dewasa')->name('program.tahfidz-dewasa');
Route::view('/program/kelas-iqra', 'kelas-iqra')->name('program.kelas-iqra');
Route::view('/program/tahfidz-anak', 'tahfidz-anak')->name('program.tahfidz-anak');
Route::view('/program/pra-sanad', 'pra-sanad')->name('program.pra-sanad');
Route::view('/program/bahasa-arab', 'bahasa-arab')->name('program.bahasa-arab');

Route::get('/sebaran-lokasi', function () {
    // 1. Ambil semua data booking offline yang aktif
    $allBookings = Booking::where('method', 'offline')
        ->whereIn('status', ['active', 'verifying'])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get(['group_name', 'student_address', 'latitude', 'longitude', 'program_type', 'maps_link']);

    // 2. Kumpulkan maps_link yang valid berdasarkan nama kelompok
    $groupMapsLinks = $allBookings->whereNotNull('maps_link')
        ->pluck('maps_link', 'group_name')
        ->toArray();

    // 3. Suntikkan otomatis link tersebut ke santri lain yang sekelompok tapi maps_link-nya NULL
    $lokasiSantri = $allBookings->map(function ($booking) use ($groupMapsLinks) {
        if (empty($booking->maps_link) && !empty($booking->group_name) && isset($groupMapsLinks[$booking->group_name])) {
            $booking->maps_link = $groupMapsLinks[$booking->group_name];
        }
        return $booking;
    });

    return view('sebaran-lokasi', compact('lokasiSantri'));
})->name('sebaran-lokasi.index');

// Route untuk Simpan Ulasan (POST)
Route::post('/reviews', [HomeController::class, 'storeReview'])->name('reviews.store');

// Route untuk Halaman Daftar Artikel & Detail Artikel
Route::get('/artikel', [BlogController::class, 'index'])->name('blog.index');
Route::get('/artikel/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Rute Lupa Password
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');

// ROUTE HALAMAN DONASI
Route::get('/donasi', [DonationController::class, 'index'])->name('donasi.index');
Route::get('/donasi/{slug}', [DonationController::class, 'show'])->name('donasi.show');

// [BARU] Route untuk memproses form pembayaran & Halaman Sukses (Manual Bank)
Route::post('/donasi/{slug}/proses', [DonationController::class, 'store'])->name('donasi.store');
Route::get('/donasi/sukses/{reference}', [DonationController::class, 'success'])->name('donasi.success');

// Rute Reset Password (dari link email)
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->middleware('guest')->name('password.update');

Route::post('/notifications/mark-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('student.notifications.read');

// routes/web.php
Route::get('/galeri', [\App\Http\Controllers\HomeController::class, 'galeri'])->name('galeri.index');

// ==============================================================================
// 2. FITUR KONTAK KAMI
// ==============================================================================

// 1. INI ROUTE YANG HILANG (Untuk menampilkan halaman kontak)
Route::get('/kontak', function () {
    return view('contact');
})->name('contact');

// 2. INI ROUTE UNTUK MENGIRIM PESAN (Yang notifikasinya sudah difilter)
Route::post('/kontak', function (Illuminate\Http\Request $request) {
    if ($request->filled('bot_trap')) {
        return back()->with('success', 'Alhamdulillah, pesan Anda telah terkirim!');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'subject' => 'required|string|max:200',
        'message' => 'required|string|max:3000',
        'email' => [
            'required',
            'string',
            'max:100',
            function ($attribute, $value, $fail) {
                $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL);
                $isPhone = preg_match('/^[0-9+]+$/', $value);
                if (!$isEmail && !$isPhone) {
                    $fail('Kolom ini harus diisi dengan Email yang valid atau Nomor HP.');
                }
            },
        ],
    ]);

    \App\Models\ContactMessage::create($validated);

    // ====================================================================
    // FILTER NOTIFIKASI OTOMATIS BERDASARKAN ROLE ADMIN DI DATABASE
    // ====================================================================
    $recipients = \App\Models\User::where('role', 'admin')->get();

    if ($recipients->isNotEmpty()) {
        \Filament\Notifications\Notification::make()
            ->title('Pesan Kontak Baru')
            ->body("Dari: {$validated['name']} \nKontak: {$validated['email']}")
            ->icon('heroicon-o-chat-bubble-left-right')
            ->success()
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label('Lihat Pesan')
                    ->url(\App\Filament\Resources\ContactMessageResource::getUrl('index'))
                    ->button(),
            ])
            ->sendToDatabase($recipients);
    }

    return back()->with('success', 'Alhamdulillah, pesan Anda telah terkirim! Tim kami akan segera menghubungi Anda.');
})->name('contact.store')->middleware('throttle:3,1');


// ==============================================================================
// 3. FITUR KARIR / LAMARAN GURU
// ==============================================================================

Route::get('/karir', function () {
    return view('career');
})->name('career');

Route::post('/karir', function (Request $request) {
    if ($request->filled('bot_trap')) {
        return back()->with('success', 'MasyaAllah! Lamaran Anda berhasil dikirim.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:150',
        'email' => 'required|email:dns|max:100',
        'phone' => 'required|string|max:20',
        'pob' => 'required|string|max:100',
        'dob' => 'required|date',
        'gender' => 'required|in:L,P',
        'marital_status' => 'required|in:single,married',
        'address' => 'required|string|max:500',
        'last_education' => 'required|string|max:50',
        'institution' => 'required|string|max:150',
        'memorization_juz' => 'required|string|max:50',
        'arabic_skill' => 'required|string|max:50',
        'cv_file' => 'required|mimes:pdf|max:2048',
        'photo_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'certificate_file' => 'nullable|mimes:pdf,jpg,png|max:5048',
    ]);

    $cvPath = $request->file('cv_file')->store('applicants/cv', 'public');
    $photoPath = $request->file('photo_file')->store('applicants/photo', 'public');
    $certPath = $request->hasFile('certificate_file')
        ? $request->file('certificate_file')->store('applicants/cert', 'public')
        : null;

    TeacherApplication::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'pob' => $validated['pob'],
        'dob' => $validated['dob'],
        'gender' => $validated['gender'],
        'marital_status' => $validated['marital_status'],
        'address' => $validated['address'],
        'last_education' => $validated['last_education'],
        'institution' => $validated['institution'],
        'memorization_juz' => $validated['memorization_juz'],
        'has_sanad' => $request->has('has_sanad'),
        'sanad_details' => $request->input('sanad_details'),
        'arabic_skill' => $validated['arabic_skill'],
        'cv_path' => $cvPath,
        'photo_path' => $photoPath,
        'certificate_path' => $certPath,
    ]);

    // ==============================================================================
    // [PERBAIKAN] Kunci notifikasi HANYA untuk user dengan role 'admin'
    // ==============================================================================
    $admins = User::where('role', 'admin')->get();
    
    Notification::make()
        ->title('Pelamar Guru Baru')
        ->body("Nama: {$validated['name']} \nHafalan: {$validated['memorization_juz']} Juz")
        ->icon('heroicon-o-academic-cap')
        ->success()
        ->actions([
            \Filament\Notifications\Actions\Action::make('view')
                ->label('Cek Lamaran')
                ->url(TeacherApplicationResource::getUrl('index'))
                ->button(),
        ])
        ->sendToDatabase($admins);

    return back()->with('success', 'MasyaAllah! Lamaran Anda berhasil dikirim. HRD kami akan segera mereview berkas Anda.');
})->name('career.store')->middleware('throttle:3,1');


// ==============================================================================
// 4. AUTHENTICATION & DASHBOARD
// ==============================================================================

// --- GUEST (BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showAuth'])->name('login');
    Route::post('/login', [StudentAuthController::class, 'processLogin'])->name('login.process');
    Route::post('/register', [StudentAuthController::class, 'processRegister'])->name('register.process');
});

// --- AUTH (SUDAH LOGIN) ---
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');

    // --- KHUSUS SANTRI ---
    Route::middleware('student.check')->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

        // =====================================================
        // ROUTE ONBOARDING LEVEL SANTRI
        // =====================================================
        Route::post('/student/save-level', function (Request $request) {
            $request->validate(['student_level' => 'required|string']);

            auth()->user()->update([
                'student_level' => $request->student_level
            ]);

            return back()->with('success', 'Level kemampuan berhasil disimpan! Selamat belajar.');
        })->name('student.save_level');

        // Katalog Guru
        Route::get('/teachers', [StudentDashboardController::class, 'allTeachers'])->name('student.teachers.index');
        Route::get('/teacher/{id}', [StudentDashboardController::class, 'showTeacher'])->name('student.teachers.show');

        // Infaq
        Route::post('/infaq/store', [InfaqController::class, 'store'])->name('infaq.store');
        Route::post('/infaq/{id}/upload', [InfaqController::class, 'upload'])->name('infaq.upload');

        // Booking Kelas
        Route::get('/booking/{teacher_id}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking/{teacher_id}', [BookingController::class, 'store'])->name('booking.store');
        Route::post('/booking/{id}/upload', [BookingController::class, 'uploadPayment'])->name('booking.upload');
        Route::post('/booking/{id}/confirm-free', [\App\Http\Controllers\BookingController::class, 'confirmFree'])->name('booking.confirm_free');
        
        Route::get('/student/riwayat-presensi', [App\Http\Controllers\StudentDashboardController::class, 'riwayatPresensi'])->name('student.riwayat-presensi');

        // =====================================================
        // FITUR UJIAN / KUIS
        // =====================================================
        Route::get('/student/exam/{id}', [StudentDashboardController::class, 'showExam'])->name('student.exam.show');
        Route::post('/student/exam/{id}', [StudentDashboardController::class, 'submitExam'])->name('student.exam.submit');
        Route::post('/ask-ai', [AiAssistantController::class, 'ask'])->name('ai.ask');

        // =====================================================
        // FITUR TUGAS GURU
        // =====================================================
        Route::get('/student/tugas/{id}', [StudentDashboardController::class, 'showTask'])->name('student.task.show');
        Route::post('/student/tugas/{id}/submit', [StudentDashboardController::class, 'submitTask'])->name('student.task.submit');

        // =====================================================
        // FITUR QURAN & PROFIL
        // =====================================================

        // Route Quran
        Route::get('/quran', [QuranController::class, 'index'])->name('quran.index');
        Route::get('/quran/{nomor}', [QuranController::class, 'show'])->name('quran.show');
        Route::get('/quran/{nomor}/tafsir', [QuranController::class, 'tafsir'])->name('quran.tafsir');
        Route::post('/quran/bookmark', [QuranController::class, 'toggleBookmark'])->name('quran.bookmark');

        // 1. Profil (Edit Foto, Nama, Email, HP)
        Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('student.profile');
        Route::post('/profile', [StudentDashboardController::class, 'updateProfile'])->name('student.profile.update');

        // 2. Keamanan (Ganti Password)
        Route::get('/security', [StudentDashboardController::class, 'security'])->name('student.security');
        Route::post('/security', [StudentDashboardController::class, 'updatePassword'])->name('student.password.update');

        // 3. Pengaturan (Placeholder)
        Route::get('/settings', [StudentDashboardController::class, 'settings'])->name('student.settings');

        Route::get('/student/jadwal/{id}/join', function($id) {
            $schedule = Schedule::findOrFail($id);

            // [REVISI]: Catat absensi HADIR dan ubah status kelas menjadi SELESAI
            if ($schedule->status !== 'completed') {
                $schedule->update([
                    'student_presence' => 'present',
                    'status'           => 'completed',
                    'updated_at'       => Carbon::now()
                ]);
            }

            // Arahkan (Redirect) ke link Zoom/Gmeet
            if (!empty($schedule->meeting_link)) {
                return redirect()->away($schedule->meeting_link);
            }

            return back()->with('error', 'Link meeting belum tersedia.');
        })->name('student.jadwal.join')->middleware('auth');
        
        // =========================================================
        // Route untuk menandai materi selesai (Background API)
        // =========================================================
        Route::post('/student/material/toggle', function (\Illuminate\Http\Request $request) {
            if (auth()->check()) {
                auth()->user()->completedMaterials()->toggle($request->material_id);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false], 401);
        })->name('student.material.toggle')->middleware('web', 'auth');

    });
});