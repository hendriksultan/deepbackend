<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

// --- Model ---
use App\Models\User;
use App\Models\Booking;
use App\Models\Mutabaah;
use App\Models\MutabaahTahsin;
use App\Models\EvaluasiIqra;
use App\Models\ArabicEvaluation;
use App\Models\TeacherProfile;
use App\Models\Schedule;
use App\Models\Infaq;
use App\Models\StudyMaterial;
use App\Models\QuranBookmark;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Task;
use Carbon\Carbon;

class StudentDashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Siswa
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil Semua Booking milik siswa (Untuk list riwayat)
        $myBookings = Booking::with('teacherProfile.user')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $bookingIds = $myBookings->pluck('id');

        // 2. Filter Booking yang AKTIF (Untuk logika akses materi)
        $activeBookings = $myBookings->where('status', 'active');

        // Ambil ID Guru dari booking yang aktif
        $myTeacherIds = $activeBookings->pluck('teacher_profile_id')->unique()->filter()->toArray();

        // Ambil Metode Belajar (Online/Offline) dari booking yang aktif
        $studentMethods = $activeBookings->pluck('method')->unique()->toArray();

        // [PENTING] Ambil Nama Kelompok (Grup) tempat santri ini tergabung
        $myGroupNames = $activeBookings->pluck('group_name')->unique()->filter()->toArray();

        // 3. Ambil Jadwal Aktif
        $activeSchedules = Schedule::with(['teacherProfile.user', 'booking'])
            ->whereIn('booking_id', $bookingIds)
            ->whereBetween('start', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->orderBy('start', 'asc')
            ->get();

        // 4a. Ambil Riwayat Setoran (Mutabaah - Hafalan)
        $riwayatSetoran = Mutabaah::with('booking.teacherProfile.user')
            ->whereIn('booking_id', $bookingIds)
            ->latest('tanggal')
            ->take(5)
            ->get();

        // 4b. Ambil Riwayat Tahsin
        $riwayatTahsin = MutabaahTahsin::with('booking.teacherProfile.user')
            ->whereIn('booking_id', $bookingIds)
            ->latest('tanggal')
            ->take(5)
            ->get();

        // 4c. Ambil Riwayat Evaluasi Iqra
        $riwayatIqra = EvaluasiIqra::with('booking.teacherProfile.user')
            ->whereIn('booking_id', $bookingIds)
            ->latest('tanggal')
            ->paginate(5); // Ubah angka 10 sesuai jumlah data per halaman yang Anda inginkan

        // 4d. Ambil Riwayat Evaluasi Bahasa Arab
        $riwayatBahasa = ArabicEvaluation::with('booking.teacherProfile.user')
            ->whereIn('booking_id', $bookingIds)
            ->latest('tanggal')
            ->take(5)
            ->get();
        // =================================================================
        // HITUNG TOTAL KEHADIRAN SANTRI
        // =================================================================
        
        // 1. Total Akumulasi (Sejak awal bergabung)
        $totalKehadiran = Schedule::whereIn('booking_id', $bookingIds)
            ->where('student_presence', 'present') 
            ->count();

        // 2. Kehadiran Khusus Bulan Ini (Jurus Paling Aman bawaan Laravel)
        $kehadiranBulanIni = Schedule::whereIn('booking_id', $bookingIds)
            ->where('student_presence', 'present')
            ->whereMonth('start', \Carbon\Carbon::now()->month) // Otomatis baca bulan 05
            ->whereYear('start', \Carbon\Carbon::now()->year)   // Otomatis baca tahun 2026
            ->count();

        // =================================================================
        // 5. REKOMENDASI GURU PINTAR (GENDER & PROGRAM MUTLAK)
        // =================================================================
        $teacherQuery = TeacherProfile::with('user')->where('is_verified', true);

        // FILTER 1: GENDER (Mutlak sesuai jenis kelamin santri)
        $studentGender = $user->gender;
        if ($studentGender) {
            $teacherQuery->whereHas('user', function ($q) use ($studentGender) {
                $q->where('gender', $studentGender);
            });
        }

        // FILTER 2: PROGRAM / LEVEL (Mutlak sesuai pilihan popup)
        if ($user->student_level) {
            $level = $user->student_level; 
            
            // Dibungkus `where` agar kebal terhadap perbedaan huruf besar/kecil di Database
            $teacherQuery->where(function ($query) use ($level) {
                $query->whereJsonContains('teaching_levels', strtolower($level))
                      ->orWhereJsonContains('teaching_levels', ucfirst(strtolower($level)))
                      ->orWhereJsonContains('teaching_levels', strtoupper($level));
            });
        }

        // Eksekusi pengambilan data (Maksimal 4)
        $rekomendasiGuru = $teacherQuery->inRandomOrder()->take(4)->get();

        //==================================================================

        // 6. Cek Tagihan Infaq
        $tagihanInfaq = Infaq::where('user_id', $user->id)
            ->whereIn('status', ['unpaid', 'pending', 'rejected'])
            ->first();

       // =================================================================
        // 7. AMBIL MATERI (SMART FILTER: PROGRAM, GURU & KELOMPOK)
        // =================================================================
        $materials = StudyMaterial::with('teacherProfile.user')
            ->where('is_active', true)
            ->where(function ($query) use ($studentMethods) {
                // Filter 1: Sesuai Metode (Online/Offline/All)
                $query->where('program_type', 'all');
                if (!empty($studentMethods)) {
                    $query->orWhereIn('program_type', $studentMethods);
                }
            })
            ->where(function ($query) use ($myTeacherIds, $myGroupNames) {
                // Filter 2: Materi dari Admin (Global)
                $query->whereNull('teacher_profile_id')
                // Filter 3: Materi dari Guru yang mengajar santri ini
                    ->orWhere(function ($subQuery) use ($myTeacherIds, $myGroupNames) {
                        $subQuery->whereIn('teacher_profile_id', $myTeacherIds)
                            ->where(function ($groupQuery) use ($myGroupNames) {
                                // Tampilkan jika grupnya dikosongkan (untuk semua santri guru tsb)
                                $groupQuery->whereNull('group_name')
                                // ATAU tampilkan jika grupnya cocok dengan grup santri
                                    ->orWhereIn('group_name', $myGroupNames);
                            });
                    });
            })
            ->latest()
            ->get();

        // =================================================================
        // 8. LOGIKA MARKAH TERAKHIR (LAST READ QURAN)
        // =================================================================
        $lastRead = QuranBookmark::where('user_id', $user->id)
            ->latest()
            ->first();

        $lastReadData = null;

        if ($lastRead) {
            $suratDetail = Cache::remember("quran_surat_{$lastRead->surat_nomor}", 86400, function () use ($lastRead) {
                $response = Http::get("https://equran.id/api/v2/surat/{$lastRead->surat_nomor}");
                return $response->successful() ? $response->json()['data'] : null;
            });

            if ($suratDetail) {
                $lastReadData = [
                    'surat_nama'  => $suratDetail['namaLatin'],
                    'surat_nomor' => $lastRead->surat_nomor,
                    'ayat'        => $lastRead->ayat_nomor
                ];
            }
        }

        // =================================================================
        // 9. AMBIL DATA UJIAN / KUIS
        // =================================================================
        $availableExams = Exam::with(['teacherProfile.user', 'questions'])
            ->where('is_active', true)
            ->latest()
            ->get();

        $myAttempts = ExamAttempt::where('user_id', $user->id)
            ->pluck('score', 'exam_id')
            ->toArray();

        // =================================================================
        // 10. AMBIL DATA TUGAS (BERDASARKAN GURU & KELOMPOK AKTIF)
        // =================================================================
        $availableTugas = collect();
        
        // Pastikan santri punya guru aktif DAN tergabung dalam grup
        if (!empty($myTeacherIds) && !empty($myGroupNames)) {
            $availableTugas = Task::whereIn('teacher_profile_id', $myTeacherIds)
                ->whereIn('group_name', $myGroupNames) // <--- PENTING: Kunci Filter Grup
                ->with('teacherProfile.user')
                ->orderBy('deadline', 'asc')
                ->get();
        }

        return view('student.dashboard', compact(
            'user',
            'myBookings',
            'riwayatSetoran',
            'riwayatTahsin',
            'riwayatIqra', 
            'riwayatBahasa',
            'rekomendasiGuru',
            'activeSchedules',
            'tagihanInfaq',
            'materials',
            'lastReadData',
            'availableExams',
            'myAttempts',
            'totalKehadiran',
            'kehadiranBulanIni',
            'availableTugas' 
        ));
    }

    // =================================================================
    // FITUR PENGERJAAN UJIAN (DENGAN TIMER ANTI-CURANG)
    // =================================================================

    public function showExam($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $user = Auth::user();

        if (!$exam->is_active) {
            return redirect()->route('student.dashboard')->with('error', 'Maaf, ujian ini sedang tidak aktif.');
        }

        $attempt = ExamAttempt::firstOrCreate(
            [
                'user_id' => $user->id,
                'exam_id' => $id
            ],
            [
                'started_at' => Carbon::now(), 
                'score' => null 
            ]
        );

        if ($attempt->score !== null) {
            return redirect()->route('student.dashboard')->with('error', 'Anda sudah menyelesaikan ujian ini! Nilai: ' . $attempt->score);
        }

        $startTime = Carbon::parse($attempt->started_at);
        $endTime = $startTime->copy()->addMinutes((int) $exam->duration_minutes);
        $now = Carbon::now();

        $remainingSeconds = $now->diffInSeconds($endTime, false);

        if ($remainingSeconds <= 0) {
            $attempt->update([
                'score' => 0,
                'finished_at' => Carbon::now()
            ]);

            return redirect()->route('student.dashboard')->with('error', 'Waktu ujian telah habis.');
        }

        return view('student.exam.show', compact('exam', 'remainingSeconds', 'attempt'));
    }

    public function submitExam(Request $request, $id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $user = Auth::user();

        $attempt = ExamAttempt::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->first();

        if (!$attempt || $attempt->score !== null) {
            return redirect()->route('student.dashboard')->with('error', 'Ujian sudah disubmit sebelumnya.');
        }

        $answers = $request->input('answers', []);
        $totalScore = 0;

        foreach ($exam->questions as $q) {
            $userAnswer = $answers[$q->id] ?? null;

            if ($q->type == 'multiple_choice' || $q->type == 'true_false') {
                $jawabanSiswa = strtolower(trim((string)$userAnswer));
                $kunciJawaban = strtolower(trim((string)$q->correct_answer));

                if ($jawabanSiswa == $kunciJawaban && $kunciJawaban !== '') {
                    $totalScore += $q->points;
                }
            }
            elseif ($q->type == 'essay') {
                // Biarkan bernilai 0 sementara 
            }
        }

        $attempt->update([
            'score' => $totalScore,
            'finished_at' => Carbon::now(),
            'answers' => $answers,
        ]);

        return redirect()->route('student.dashboard')->with('success', "Alhamdulillah! Ujian selesai. Nilai Sementara: $totalScore");
    }

    // =================================================================
    // FITUR PENGUMPULAN TUGAS 
    // =================================================================

    public function showTask($id)
    {
        $tugas = Task::with('teacherProfile.user')->findOrFail($id);
        $user = Auth::user();

        // Cari tahu apakah siswa sudah pernah mengumpulkan tugas ini
        $submission = \App\Models\TaskSubmission::where('task_id', $id)
            ->where('user_id', $user->id)
            ->first();

        return view('student.tasks.show', compact('tugas', 'submission'));
    }

    public function submitTask(Request $request, $id)
    {
        $request->validate([
            'file_tugas' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,zip,mp3,wav,ogg,m4a|max:10240',
        ], [
            'file_tugas.required' => 'Anda harus memilih file untuk diunggah.',
            'file_tugas.mimes' => 'Format file harus berupa PDF, Gambar, Word, ZIP, atau Audio (MP3/WAV/OGG).',
            'file_tugas.max' => 'Ukuran file maksimal adalah 10MB.', // <--- PENTING: Teks disesuaikan
        ]);

        $task = Task::findOrFail($id);
        $user = Auth::user();

        if (Carbon::now()->isAfter($task->deadline)) {
            return back()->with('error', 'Maaf, batas waktu pengumpulan tugas ini telah berakhir.');
        }

        // Upload file
        $path = $request->file('file_tugas')->store('task_submissions', 'public');

        \App\Models\TaskSubmission::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => $user->id],
            [
                'file_path' => $path,
                'status' => 'pending', 
            ]
        );

        return redirect()->route('student.dashboard')->with('success', 'Alhamdulillah, tugas Anda berhasil dikumpulkan!');
    }

    // =================================================================
    // FITUR GURU LAINNYA
    // =================================================================

    public function allTeachers(Request $request)
    {
        $studentGender = auth()->user()->gender;

        $query = \App\Models\TeacherProfile::with('user')->where('is_verified', true);

        if ($studentGender) {
            $query->whereHas('user', function ($q) use ($studentGender) {
                $q->where('gender', $studentGender);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('province')) {
            $province = $request->province;
            $query->whereHas('user', function ($q) use ($province) {
                $q->where('province', $province);
            });
        }

        if ($request->filled('city')) {
            $city = $request->city;
            $query->whereHas('user', function ($q) use ($city) {
                $q->where('city', $city);
            });
        }

        if ($request->filled('district')) {
            $district = $request->district;
            $query->whereHas('user', function ($q) use ($district) {
                $q->where('district', $district);
            });
        }

        if ($request->filled('village')) {
            $village = $request->village;
            $query->whereHas('user', function ($q) use ($village) {
                $q->where('village', $village);
            });
        }

        $teachers = $query->paginate(12);

        return view('student.teachers.index', compact('teachers'));
    }

    public function showTeacher($id)
    {
        $guru = TeacherProfile::with(['user', 'schedules' => function ($q) {
            $q->where('start', '>=', \Carbon\Carbon::now())->orderBy('start', 'asc');
        }])->findOrFail($id);

        return view('student.teachers.show', compact('guru'));
    }

    // =================================================================
    // FITUR PROFIL, KEAMANAN, DAN PENGATURAN
    // =================================================================

    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'birth_place' => 'nullable|string|max:100',
            'birth_date'  => 'nullable|date',
            'gender'      => 'nullable|in:L,P',
            'address'     => 'nullable|string',
            
            // Validasi 4 Kolom Wilayah
            'province'    => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'district'    => 'nullable|string|max:255',
            'village'     => 'nullable|string|max:255',
        ]);

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'birth_place' => $request->birth_place,
            'birth_date'  => $request->birth_date,
            'gender'      => $request->gender,
            'address'     => $request->address,
            
            // Simpan 4 Data Wilayah ke Database
            'province'    => $request->province,
            'city'        => $request->city,
            'district'    => $request->district,
            'village'     => $request->village,
        ];

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Alhamdulillah, profil berhasil diperbarui!');
    }

    public function security()
    {
        return view('student.security');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama Anda salah.']);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah! Silakan login ulang jika diperlukan.');
    }

    public function settings()
    {
        return view('student.settings');
    }
    
    public function joinClass($id)
{
    // Mengambil data jadwal berdasarkan ID yang dikirim
    $schedule = \App\Models\Schedule::findOrFail($id);

    $now = \Carbon\Carbon::now();
    // Batasan waktu: Siswa bisa absen otomatis mulai H-30 menit hingga jam selesai kelas
    $startWaktuBuka = \Carbon\Carbon::parse($schedule->start)->subMinutes(30);
    $endWaktuTutup = \Carbon\Carbon::parse($schedule->end);

    // Cek apakah sekarang adalah waktu yang valid untuk masuk kelas
    if ($now->between($startWaktuBuka, $endWaktuTutup) && $schedule->status !== 'completed') {
        
        // REVISI: Langsung set Hadir DAN Selesai (Completed)
        $schedule->update([
            'student_presence' => 'present',
            'status'           => 'completed', // Otomatis dianggap selesai di sistem
            'updated_at'       => now()
        ]);
    }

    // Pantulkan (Redirect) santri ke link Zoom/Google Meet yang ada di database
    if (!empty($schedule->meeting_link)) {
        return redirect()->away($schedule->meeting_link);
    }

    // Jika link kosong, kembali dengan pesan error
    return back()->with('error', 'Link meeting belum tersedia atau sudah kadaluwarsa.');
}
// =================================================================
    // FITUR HALAMAN DETAIL RIWAYAT PRESENSI
    // =================================================================
    public function riwayatPresensi()
    {
        $user = Auth::user();

        // 1. Ambil ID Booking milik siswa
        $bookingIds = Booking::where('user_id', $user->id)->pluck('id');

        // 2. Ambil seluruh jadwal yang sudah ada status presensinya (baik present, permit, sick, alpa)
        $semuaPresensi = Schedule::with(['teacherProfile.user', 'booking'])
            ->whereIn('booking_id', $bookingIds)
            ->whereNotNull('student_presence')
            ->orderBy('start', 'desc')
            ->get();

        // 3. Kelompokkan Data (Grouping Ganda)
        // Group Pertama: Berdasarkan Nama Guru / Kelas
        $groupedPresensi = $semuaPresensi->groupBy(function ($jadwal) {
            $namaGuru = $jadwal->teacherProfile->user->name ?? 'Ustadz/Ustadzah';
            $namaGrup = $jadwal->booking->group_name ?? 'Kelas Privat';
            return $namaGuru . ' (' . $namaGrup . ')';
        })
        // Group Kedua: Berdasarkan Bulan di dalam masing-masing Guru
        ->map(function ($jadwalGuru) {
            return $jadwalGuru->groupBy(function ($j) {
                return \Carbon\Carbon::parse($j->start)->translatedFormat('F Y'); // Contoh: "Mei 2026"
            });
        });

        return view('student.presensi', compact('groupedPresensi'));
    }
}