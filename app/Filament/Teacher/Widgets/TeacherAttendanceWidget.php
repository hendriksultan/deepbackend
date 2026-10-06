<?php

namespace App\Filament\Teacher\Widgets;

use Filament\Widgets\Widget;
use App\Models\TeacherAttendance;
use App\Models\Schedule; // <--- [BARU] Import model Schedule
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// --- Import Model User untuk mencari Admin ---
use App\Models\User;

// Import untuk Notifikasi
use Filament\Notifications\Notification;
// --- Import Action khusus Notifikasi (diberi alias 'NotificationAction' agar tidak bentrok) ---
use Filament\Notifications\Actions\Action as NotificationAction;

// Import untuk Widget & Form
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

// [PENTING] Import Trait ini agar widget bisa upload file
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TeacherAttendanceWidget extends Widget implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;
    use WithFileUploads; // <--- [WAJIB] Masukkan Trait ini di sini

    protected static string $view = 'filament.teacher.widgets.teacher-attendance-widget';
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public $attendance;
    public $status_message;
    public $hasScheduleToday = false; // <--- [BARU] Variabel penyimpan status jadwal

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $user = Auth::user();
        if ($user && $user->teacherProfile) {
            $this->attendance = TeacherAttendance::where('teacher_profile_id', $user->teacherProfile->id)
                // GUNAKAN whereDate AGAR HANYA MENCOCOKKAN TANGGAL SAJA (Tanpa Jam)
                ->whereDate('date', Carbon::today('Asia/Jakarta'))
                ->first();

            // --- [BARU] Cek Apakah Ada Jadwal Hari Ini ---
            $jadwalHariIni = Schedule::where('teacher_profile_id', $user->teacherProfile->id)
                ->whereDate('start', Carbon::today('Asia/Jakarta'))
                ->count();

            $this->hasScheduleToday = $jadwalHariIni > 0;
        }
    }

    // --- LOGIC TOMBOL MASUK ---
    public function clockIn()
    {
        $user = Auth::user();

        if (!$user->teacherProfile) {
            Notification::make()->title('Gagal')->body('Profil Guru belum ada.')->danger()->send();
            return;
        }

        // --- [BARU] Keamanan Ganda: Tolak absen jika tidak ada jadwal ---
        if (!$this->hasScheduleToday) {
            Notification::make()->title('Tidak Ada Jadwal')->body('Anda tidak memiliki jadwal mengajar hari ini.')->danger()->send();
            return;
        }

        // 1. Simpan data absensi ke database
        TeacherAttendance::create([
            'teacher_profile_id' => $user->teacherProfile->id,
            'date' => Carbon::today('Asia/Jakarta'),
            'clock_in' => Carbon::now('Asia/Jakarta'),
            'status' => 'present',
        ]);

        // --- 2. KIRIM NOTIFIKASI KE ADMIN ---
        // Cari semua user yang memiliki akses Admin
        $admins = User::where('role', 'admin')->get();

        // Buat dan kirim notifikasi
        Notification::make()
            ->title('Absensi Guru Baru! 🧑‍🏫')
            ->body("**{$user->name}** baru saja melakukan absen masuk.")
            ->success()
            ->icon('heroicon-o-check-circle')
            ->actions([
                // Tombol ini akan mengarahkan admin ke halaman tabel Absensi Guru
                NotificationAction::make('view')
                    ->label('Lihat Absensi')
                    ->url('/admin/teacher-attendances') // Sesuaikan dengan URL resource Absensi Anda
                    ->button(),
            ])
            ->sendToDatabase($admins);
        // -------------------------------------------

        // 3. Tampilkan notifikasi sukses untuk Guru yang sedang login
        Notification::make()->title('Berhasil Absen Masuk')->success()->send();
        $this->refreshData();
    }

    // --- LOGIC TOMBOL PULANG ---
    public function clockOut()
    {
        if ($this->attendance) {
            $this->attendance->update(['clock_out' => Carbon::now('Asia/Jakarta')]);
            Notification::make()->title('Berhasil Absen Pulang')->success()->send();
            $this->refreshData();
        }
    }

    // --- ACTION POPUP: IZIN ---
    public function permitAction(): Action
    {
        return Action::make('permit')
            ->label('Izin')
            ->color('warning')
            ->icon('heroicon-o-document-text')
            ->form([
                Textarea::make('note')
                    ->label('Alasan Izin')
                    ->required(),
                FileUpload::make('proof_file')
                    ->label('Bukti / Surat (Opsional)')
                    ->directory('attendance-proofs'),
            ])
            // Tambahkan parameter $livewire untuk mengakses variabel hasScheduleToday
            ->action(function (array $data, $livewire) {
                $user = Auth::user();
                if (!$user->teacherProfile) return;

                if (!$livewire->hasScheduleToday) {
                    Notification::make()->title('Tidak Ada Jadwal')->body('Anda tidak memiliki jadwal hari ini.')->danger()->send();
                    return;
                }

                TeacherAttendance::create([
                    'teacher_profile_id' => $user->teacherProfile->id,
                    'date' => Carbon::today('Asia/Jakarta'),
                    'status' => 'permit', // Status Izin
                    'note' => $data['note'],
                    'proof_file' => $data['proof_file'] ?? null,
                ]);

                Notification::make()->title('Pengajuan Izin Berhasil')->success()->send();
                $livewire->refreshData();
            });
    }

    // --- ACTION POPUP: SAKIT ---
    public function sickAction(): Action
    {
        return Action::make('sick')
            ->label('Sakit')
            ->color('danger')
            ->icon('heroicon-o-face-frown')
            ->form([
                Textarea::make('note')
                    ->label('Keterangan Sakit')
                    ->required(),
                FileUpload::make('proof_file')
                    ->label('Foto Surat Dokter / Bukti')
                    ->directory('attendance-proofs')
                    ->required(), // Kalau sakit wajib ada bukti
            ])
            ->action(function (array $data, $livewire) {
                $user = Auth::user();
                if (!$user->teacherProfile) return;

                if (!$livewire->hasScheduleToday) {
                    Notification::make()->title('Tidak Ada Jadwal')->body('Anda tidak memiliki jadwal hari ini.')->danger()->send();
                    return;
                }

                TeacherAttendance::create([
                    'teacher_profile_id' => $user->teacherProfile->id,
                    'date' => Carbon::today('Asia/Jakarta'),
                    'status' => 'sick', // Status Sakit
                    'note' => $data['note'],
                    'proof_file' => $data['proof_file'] ?? null,
                ]);

                Notification::make()->title('Laporan Sakit Berhasil')->success()->send();
                $livewire->refreshData();
            });
    }
}