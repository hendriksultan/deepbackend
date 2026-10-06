<?php

namespace App\Filament\Teacher\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

// IMPORT TAMBAHAN UNTUK TABS FILTER
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\ToggleButtons;

class TodayClassesWidget extends BaseWidget
{
    protected static ?string $heading = 'Jadwal Mengajar Bulan Ini';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Schedule::query()
                    ->with(['booking.user', 'teacherProfile'])
                    ->where('teacher_profile_id', Auth::user()->teacherProfile->id ?? 0)
                    ->whereBetween('start', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ])
                    ->orderBy('start', 'asc')
            )
            // =========================================================
            // INJEKSI CSS SUPER KUAT & FLEKSIBEL
            // =========================================================
            ->description(new HtmlString('
                <style>
                    .fi-ta-filter-form { max-width: 100% !important; }
                    
                    .mobile-scroll-tabs {
                        width: 100% !important; max-width: 100% !important;
                        overflow-x: auto !important; -webkit-overflow-scrolling: touch;
                        scrollbar-width: none; -ms-overflow-style: none;
                    }
                    .mobile-scroll-tabs::-webkit-scrollbar { display: none; }
                    .mobile-scroll-tabs div[role="group"] {
                        display: flex !important; flex-wrap: nowrap !important;
                        width: max-content !important; min-width: 100% !important;
                    }
                    .mobile-scroll-tabs label {
                        flex: 1 1 auto !important; white-space: nowrap !important; justify-content: center !important;
                    }

                    /* [PERBAIKAN CSS] Memaksa Title & Description menjadi 1 baris */
                    .fi-ta-group-header-info {
                        display: flex !important;
                        align-items: center !important;
                        width: 100% !important;
                        gap: 8px;
                    }
                    .fi-ta-group-header-description {
                        flex-grow: 1 !important;
                        margin-top: 0 !important; /* Hilangkan jarak atas */
                    }
                </style>
            '))
            // =========================================================
            // GROUPING KELAS (ANTI ERROR JAVASCRIPT)
            // =========================================================
            ->defaultGroup('title')
            ->groups([
                Group::make('title')
                    ->label('Kelas')
                    ->collapsible(true)
                    ->titlePrefixedWithLabel(false)
                    
                    // 1. TITLE MURNI TEKS (AGAR FITUR BUKA-TUTUP TIDAK ERROR)
                    ->getTitleFromRecordUsing(fn(Schedule $record) => $record->title)
                    
                    // 2. TANGGAL, JAM & LOGIKA TOMBOL ZOOM
                    ->getDescriptionFromRecordUsing(function (Schedule $record) {
                        $hariTanggal = \Carbon\Carbon::parse($record->start)->translatedFormat('l, d M Y');
                        $jam = \Carbon\Carbon::parse($record->start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($record->end)->format('H:i') . ' WIB';

                        $buttonHtml = '';
                        if ($record->booking && $record->booking->method === 'online') {
                            $groupSchedules = Schedule::where('teacher_profile_id', $record->teacher_profile_id)
                                ->where('title', $record->title)
                                ->where('start', $record->start)
                                ->where('end', $record->end)
                                ->get();

                            $missingLinkCount = $groupSchedules->filter(fn($s) => empty($s->meeting_link))->count();
                            
                            if ($missingLinkCount === 0 && $record->meeting_link) {
                                // =======================================================
                                // [FITUR BARU] KUNCI WAKTU ZOOM (H-20 MENIT BARU BUKA)
                                // =======================================================
                                $waktuBuka = \Carbon\Carbon::parse($record->start)->subMinutes(20);
                                $sekarang = \Carbon\Carbon::now();

                                if ($sekarang->lessThan($waktuBuka)) {
                                    // JIKA BELUM WAKTUNYA (H-20) -> TOMBOL ABU-ABU TERKUNCI
                                    $buttonText = 'Aktif H-20 Menit Sebelum Kelas Mulai';
                                    $buttonHtml = '
                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 0.8rem; font-weight: 600; color: #6b7280; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 8px; cursor: not-allowed; text-decoration: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 14px; height: 14px;">
                                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                            </svg>
                                            ' . $buttonText . '
                                        </span>
                                    ';
                                } else {
                                    // JIKA SUDAH MASUK H-20 ATAU LEBIH -> TOMBOL BIRU AKTIF BISA DIKLIK
                                    $isReady = $record->status !== 'completed';
                                    $styleTag = $isReady ? '<style>@keyframes pulseGlow { 0% { box-shadow: 0 0 0 0 rgba(29, 78, 216, 0.4); } 70% { box-shadow: 0 0 0 8px rgba(29, 78, 216, 0); } 100% { box-shadow: 0 0 0 0 rgba(29, 78, 216, 0); } }</style>' : '';
                                    $animationCss = $isReady ? 'animation: pulseGlow 2s infinite;' : '';
                                    $buttonText = $isReady ? 'Mulai Mengajar' : 'Ruang Kelas Online';

                                    $buttonHtml = '
                                        ' . $styleTag . '
                                        <a href="' . $record->meeting_link . '" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 0.8rem; font-weight: 600; color: #1d4ed8; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; text-decoration: none; ' . $animationCss . '">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 14px; height: 14px;">
                                                <path d="M3.25 4A2.25 2.25 0 001 6.25v7.5A2.25 2.25 0 003.25 16h7.5A2.25 2.25 0 0013 13.75v-7.5A2.25 2.25 0 0010.75 4h-7.5zM19 4.75a.75.75 0 00-1.28-.53l-3 3a.75.75 0 00-.22.53v4.5c0 .199.079.39.22.53l3 3a.75.75 0 001.28-.53V4.75z" />
                                            </svg>
                                            ' . $buttonText . '
                                        </a>
                                    ';
                                }

                            } else {
                                $totalSantri = $groupSchedules->count();
                                $warningText = ($missingLinkCount === $totalSantri) ? 'Belum Diatur' : "Menunggu {$missingLinkCount} Santri";

                                $buttonHtml = '
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 0.8rem; font-weight: 500; color: #b45309; background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 14px; height: 14px;">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        ' . $warningText . '
                                    </span>
                                ';
                            }
                        }
                        
                        // Menggabungkan Tanggal dan Tombol Zoom dalam satu baris fleksibel
                        return new HtmlString("
                            <div style='display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 20px; margin-top: 4px;'>
                                <span style='font-size: 0.85rem; color: #6b7280; font-weight: normal; margin-left: 4px; line-height: 1.5;'>
                                    &bull; {$hariTanggal} ({$jam})
                                </span>
                                <div style='margin-left: auto; padding-right: 12px;'>
                                    {$buttonHtml}
                                </div>
                            </div>
                        ");
                    })
            ])
            ->columns([
                Tables\Columns\TextColumn::make('start')
                    ->label('Tgl & Waktu')
                    ->formatStateUsing(fn($state, Schedule $record) => $state->format('d M, H:i') . ' - ' . $record->end->format('H:i')),

                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Santri')
                    ->searchable()
                    ->html() 
                    ->state(function (Schedule $record) {
                        $name = $record->booking->student_name ?? '-';
                        $phone = $record->booking->whatsapp ?? '-';
                        $group = $record->booking->group_name ?? '-';

                        $photoUrl = null;
                        if ($record->booking->user && $record->booking->user->profile_photo_path) {
                            $photoUrl = Storage::url($record->booking->user->profile_photo_path);
                        }

                        $avatarHtml = $photoUrl
                            ? "<img src='{$photoUrl}' class='w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700'>"
                            : "<div class='w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 flex items-center justify-center font-bold border-2 border-gray-200 dark:border-gray-700'>" . substr($name, 0, 1) . "</div>";

                        return "
        <div class='flex items-center gap-3'>
            {$avatarHtml}
            <div class='flex flex-col'>
                <span class='font-bold text-sm text-gray-900 dark:text-white'>{$name}</span>
                <span class='text-xs text-gray-500 dark:text-gray-400'>{$group}</span>
                <div class='flex items-center gap-1 mt-1'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' class='w-3 h-3 text-green-500'>
                        <path d='M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z' />
                    </svg>
                    <a href='https://wa.me/{$phone}' target='_blank' style='color: #16a34a; text-decoration: none;' class='text-xs font-medium hover:underline'>
                       {$phone}
                    </a>
                </div>
            </div>
        </div>";
                    }),

                Tables\Columns\TextColumn::make('booking.method')
                    ->label('Metode')
                    ->badge()
                    ->colors(['info' => 'online', 'warning' => 'offline'])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('location_info')
                    ->label('Lokasi')
                    ->state(function (Schedule $record) {
                        return ($record->booking && $record->booking->method === 'offline')
                            ? '🏠 ' . \Illuminate\Support\Str::limit($record->booking->student_address ?? 'Alamat Kosong', 20)
                            : '-';
                    })
                    ->color('gray')
                    ->tooltip(fn(Schedule $record) => ($record->booking && $record->booking->method === 'offline') ? ($record->booking->student_address ?? 'Alamat belum diisi') : null),

                Tables\Columns\TextColumn::make('student_presence')
                    ->label('Kehadiran')
                    ->badge()
                    ->colors(['success' => 'present', 'warning' => 'permit', 'danger' => 'sick', 'gray' => 'alpha'])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        'alpha' => 'Alpha',
                        default => 'Belum Absen',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors(['success' => 'completed', 'gray' => 'pending'])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'completed' => 'Selesai',
                        'pending' => 'Belum Mulai',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('kategori_waktu')
                    ->columnSpan('full') 
                    ->form([
                        ToggleButtons::make('waktu')
                            ->label('') 
                            ->extraAttributes(['class' => 'mobile-scroll-tabs w-full'])
                            ->options([
                                'semua'       => 'Semua Jadwal',
                                'hari_ini'    => 'Kelas Hari Ini',
                                'akan_datang' => 'Akan Datang',
                                'selesai'     => 'Riwayat Selesai',
                            ])
                            ->icons([
                                'semua'       => 'heroicon-m-squares-2x2',
                                'hari_ini'    => 'heroicon-m-play-circle',
                                'akan_datang' => 'heroicon-m-clock',
                                'selesai'     => 'heroicon-m-check-badge',
                            ])
                            ->colors([
                                'semua'       => 'gray',
                                'hari_ini'    => 'success', 
                                'akan_datang' => 'info',    
                                'selesai'     => 'gray',
                            ])
                            ->inline()  
                            ->grouped() 
                            ->default('hari_ini'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $val = $data['waktu'] ?? 'hari_ini';
                        
                        if ($val === 'hari_ini') {
                            return $query->whereDate('start', Carbon::today())
                                         ->where('status', '!=', 'completed');
                        } elseif ($val === 'akan_datang') {
                            return $query->whereDate('start', '>', Carbon::today())
                                         ->where('status', 'pending');
                        } elseif ($val === 'selesai') {
                            return $query->where(function ($q) {
                                $q->where('status', 'completed')
                                  ->orWhereDate('start', '<', Carbon::today());
                            });
                        }
                        
                        return $query;
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(1) 
            ->actions([
                Action::make('update_attendance')
                    ->button()
                    ->label(function (Schedule $record) {
                        if ($record->status === 'completed') return 'Edit';
                        if (Carbon::parse($record->start)->startOfDay()->isFuture()) return 'Belum Waktunya';
                        
                        if ($record->student_presence === 'present') return 'Santri Hadir (Selesaikan)';
                        return 'Isi Absen';
                    })
                    ->icon(function (Schedule $record) {
                        if ($record->status === 'completed') return 'heroicon-o-pencil-square';
                        if (Carbon::parse($record->start)->startOfDay()->isFuture()) return 'heroicon-o-clock';
                        
                        if ($record->student_presence === 'present') return 'heroicon-o-check-circle';
                        return 'heroicon-o-pencil-square';
                    })
                    ->color(function (Schedule $record) {
                        if ($record->status === 'completed') return 'gray';
                        if (Carbon::parse($record->start)->startOfDay()->isFuture()) return 'gray';
                        
                        if ($record->student_presence === 'present') return 'success';
                        return 'primary';
                    })
                    ->disabled(function (Schedule $record) {
                        return Carbon::parse($record->start)->startOfDay()->isFuture();
                    })
                    ->modalHeading('Absensi & Jurnal Mengajar')
                    ->mountUsing(function (Forms\ComponentContainer $form, Schedule $record) {
                        $form->fill([
                            'student_presence' => $record->student_presence ?? 'present',
                            'teaching_note'    => $record->teaching_note,
                        ]);
                    })
                    ->form([
                        Radio::make('student_presence')
                            ->label('Kehadiran Siswa')
                            ->options(['present' => 'Hadir', 'sick' => 'Sakit', 'permit' => 'Izin', 'alpha' => 'Alpha'])
                            ->required()->inline(),
                        Textarea::make('teaching_note')
                            ->label('Jurnal (Opsional)')
                            ->nullable(),
                    ])
                    ->action(function (Schedule $record, array $data) {
                        $record->update([
                            'status' => 'completed',
                            'student_presence' => $data['student_presence'],
                            'teaching_note' => $data['teaching_note'] ?? null,
                        ]);
                        Notification::make()->title('Disimpan & Kelas Selesai')->success()->send();
                    }),
            ])
            ->paginated([5, 10, 25, 50, 'all'])
            ->defaultPaginationPageOption(10);
    }
}