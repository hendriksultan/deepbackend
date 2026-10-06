<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Penjadwalan';
    protected static ?string $navigationGroup = 'Manajemen Akademik';

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informasi Jadwal')
                ->description('Atur waktu, peserta didik, dan metode belajar.')
                ->schema([
                    // 1. PILIH GURU
                    Forms\Components\Select::make('teacher_profile_id')
                        ->label('Guru Pengajar')
                        ->options(function () {
                            return \App\Models\TeacherProfile::with('user')
                                ->get()
                                ->mapWithKeys(function ($profile) {
                                    return [$profile->id => $profile->user->name ?? 'Tanpa Nama'];
                                });
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function(Set $set) {
                            $set('booking_id', null);
                            $set('booking_ids', null);
                            $set('map_info', null);
                            $set('koordinat_display', null);
                        }),

                    // ========================================================
                    // 2A. PILIH BANYAK SANTRI (CREATE MASSAL)
                    // ========================================================
                    Forms\Components\Select::make('booking_ids')
                        ->label('Pilih Santri (Bisa pilih lebih dari 1)')
                        ->multiple()
                        ->options(function (Get $get) {
                            $teacherId = $get('teacher_profile_id');
                            $query = Booking::whereIn('status', ['active', 'verifying', 'pending']);
                            
                            if ($teacherId) {
                                $query->where('teacher_profile_id', $teacherId);
                            }

                            return $query->orderBy('group_name')
                                ->get()
                                ->groupBy(fn($b) => $b->group_name ?: 'Tanpa Kelompok')
                                ->map(fn($group) => $group->pluck('student_name', 'id'))
                                ->toArray();
                        })
                        ->searchable()
                        ->required()
                        ->columnSpanFull()
                        ->hiddenOn('edit')
                        ->live()
                        // ========================================================
                        // 2A. PILIH BANYAK SANTRI (CREATE MASSAL)
                        // ========================================================
                        ->afterStateUpdated(function ($state, Set $set) {
                            if (empty($state)) {
                                $set('method_display', '-');
                                $set('student_address_info', '-');
                                $set('title', null);
                                $set('map_info', null);
                                $set('koordinat_display', null);
                                return;
                            }

                            // Mengamankan index array dengan array_values()
                            $firstId = is_array($state) ? array_values($state)[0] : $state;
                            $booking = Booking::find($firstId);
                            
                            if ($booking) {
                                $set('title', $booking->group_name ?? ucfirst($booking->program_type ?? 'Kelas Mengaji'));
                                $set('method_display', strtoupper($booking->method . ($booking->method == 'offline' ? ' (Home Visit)' : '')));
                                $set('student_address_info', $booking->method == 'offline' ? $booking->student_address : '-');
                                
                                if ($booking->method === 'offline') {
                                    
                                    // ========================================================
                                    // [PERBAIKAN]: DETEKSI LINK OTOMATIS JIKA SANTRI PERTAMA NULL
                                    // ========================================================
                                    $finalMapsLink = $booking->maps_link;
                                    if (empty($finalMapsLink) && !empty($booking->group_name)) {
                                        $finalMapsLink = Booking::where('group_name', $booking->group_name)
                                            ->where('teacher_profile_id', $booking->teacher_profile_id)
                                            ->whereNotNull('maps_link')
                                            ->value('maps_link'); 
                                    }

                                    $set('koordinat_display', $booking->latitude . ', ' . $booking->longitude);
                                    $set('map_info', [
                                        'group_name' => $booking->group_name ?? 'Tanpa Nama',
                                        'address'    => $booking->student_address ?? 'Alamat tidak tersedia',
                                        'lat'        => $booking->latitude,
                                        'lng'        => $booking->longitude,
                                        'maps_link'  => $finalMapsLink, // <--- Gunakan link cadangan kelompok jika tersedia
                                        'jumlah'     => is_array($state) ? count($state) : 1, // Tetap gunakan ini untuk massal
                                    ]);
                                } else {
                                    $set('koordinat_display', null);
                                    $set('map_info', null);
                                }
                            }
                        }),

                    // ========================================================
                    // 2B. PILIH 1 SANTRI (EDIT SATUAN)
                    // ========================================================
                    Forms\Components\Select::make('booking_id')
                        ->label('Santri')
                        ->placeholder('Pilih satu santri')
                        ->options(function (Get $get) {
                            $teacherId = $get('teacher_profile_id');
                            if (!$teacherId) return [];
                            return Booking::query()
                                ->where('teacher_profile_id', $teacherId)
                                ->whereIn('status', ['active', 'verifying', 'pending'])
                                ->pluck('student_name', 'id');
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->hiddenOn('create')
                        ->live() 
                        ->afterStateUpdated(function ($state, Set $set) {
                            if (!$state) {
                                $set('method_display', '-');
                                $set('student_address_info', '-');
                                $set('title', null);
                                $set('map_info', null);
                                $set('koordinat_display', null);
                                return;
                            }

                            $booking = Booking::find($state);
                            if ($booking) {
                                $set('title', $booking->group_name ?? ucfirst($booking->program_type ?? 'Kelas Mengaji'));
                                $set('method_display', strtoupper($booking->method . ($booking->method == 'offline' ? ' (Home Visit)' : '')));
                                $set('student_address_info', $booking->method == 'offline' ? $booking->student_address : '-');
                                
                                if ($booking->method === 'offline') {
                                    
                                    // 1. CARI LINK MAPS OTOMATIS DARI TEMAN SEKELOMPOK (JIKA KOSONG)
                                    $finalMapsLink = $booking->maps_link;
                                    if (empty($finalMapsLink) && !empty($booking->group_name)) {
                                        $finalMapsLink = Booking::where('group_name', $booking->group_name)
                                            ->where('teacher_profile_id', $booking->teacher_profile_id)
                                            ->whereNotNull('maps_link')
                                            ->value('maps_link'); 
                                    }

                                    // 2. HITUNG JUMLAH PESERTA BERDASARKAN KOORDINAT (SINKRON DENGAN JS)
                                    $totalPeserta = Booking::where('latitude', $booking->latitude)
                                        ->where('longitude', $booking->longitude)
                                        ->whereIn('status', ['active', 'verifying'])
                                        ->count();
                                        
                                    // Set minimal 1 jika hasil count 0 (misal statusnya masih pending)
                                    $totalPeserta = $totalPeserta > 0 ? $totalPeserta : 1;

                                    $set('koordinat_display', $booking->latitude . ', ' . $booking->longitude);
                                    $set('map_info', [
                                        'group_name' => $booking->group_name ?? 'Tanpa Nama',
                                        'address'    => $booking->student_address ?? 'Alamat tidak tersedia',
                                        'lat'        => $booking->latitude,
                                        'lng'        => $booking->longitude,
                                        'maps_link'  => $finalMapsLink, // <--- Menggunakan variabel link yang sudah difilter
                                        'jumlah'     => $totalPeserta,  // <--- Menggunakan angka yang dihitung dari koordinat
                                    ]);
                                } else {
                                    $set('koordinat_display', null);
                                    $set('map_info', null);
                                }
                            }
                        }),

                    Forms\Components\TextInput::make('method_display')
                        ->label('Metode Belajar')
                        ->disabled()
                        ->dehydrated(false),

                    Forms\Components\TextInput::make('meeting_link')
                        ->label('Link Meeting (Zoom / GMeet)')
                        ->placeholder('https://zoom.us/j/...')
                        ->url()
                        ->suffixIcon('heroicon-m-video-camera')
                        ->visible(function (Get $get, string $operation) {
                            $ids = $get('booking_ids');
                            $id = $operation === 'create' 
                                ? (is_array($ids) && count($ids) > 0 ? array_values($ids)[0] : null) 
                                : $get('booking_id');
                                
                            if (!$id) return false;
                            $booking = Booking::find($id);
                            return $booking && $booking->method === 'online';
                        })
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('student_address_info')
                        ->label('Lokasi Belajar (Alamat Santri)')
                        ->rows(3)
                        ->disabled()
                        ->dehydrated(false)
                        ->visible(function (Get $get, string $operation) {
                            $ids = $get('booking_ids');
                            $id = $operation === 'create' 
                                ? (is_array($ids) && count($ids) > 0 ? array_values($ids)[0] : null) 
                                : $get('booking_id');
                                
                            if (!$id) return false;
                            $booking = Booking::find($id);
                            return $booking && $booking->method === 'offline';
                        })
                        ->columnSpanFull(),
                        
                    // ========================================================
                    // [BARU] FIELD MENAMPILKAN TITIK KOORDINAT (DISABLED)
                    // ========================================================
                    Forms\Components\TextInput::make('koordinat_display')
                        ->label('Titik Koordinat (Latitude, Longitude)')
                        ->disabled()
                        ->dehydrated(false)
                        ->visible(function (Get $get, string $operation) {
                            $ids = $get('booking_ids');
                            $id = $operation === 'create' 
                                ? (is_array($ids) && count($ids) > 0 ? array_values($ids)[0] : null) 
                                : $get('booking_id');
                                
                            if (!$id) return false;
                            $booking = Booking::find($id);
                            return $booking && $booking->method === 'offline';
                        })
                        ->columnSpanFull(),
                        
                    // ========================================================
                    // STATE PETA DENGAN VIEW FIELD TERINTEGRASI
                    // ========================================================
                    Forms\Components\ViewField::make('map_info')
                        ->view('filament.components.booking-map')
                        ->columnSpanFull()
                        ->dehydrated(false) // Mencegah filament mencoba menyimpan field ini ke database
                        ->visible(function (Get $get, string $operation) {
                            $ids = $get('booking_ids');
                            $id = $operation === 'create' 
                                ? (is_array($ids) && count($ids) > 0 ? array_values($ids)[0] : null) 
                                : $get('booking_id');
                                
                            if (!$id) return false;
                            $booking = Booking::find($id);
                            return $booking && $booking->method === 'offline';
                        }),

                    Forms\Components\TextInput::make('title')
                        ->label('Nama Kegiatan / Kelas')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DateTimePicker::make('start')
                                ->label('Waktu Mulai')->seconds(false)->required(),
                            Forms\Components\DateTimePicker::make('end')
                                ->label('Waktu Selesai')->seconds(false)->required(),
                        ]),
                ])->columns(2),

            Forms\Components\Section::make('Laporan & Absensi')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status Kelas')
                        ->options(['pending' => 'Belum Terlaksana', 'completed' => 'Sudah Terlaksana'])
                        ->default('pending')
                        ->required(),
                    Forms\Components\Select::make('student_presence')
                        ->label('Kehadiran Santri')
                        ->options(['present' => 'Hadir', 'sick' => 'Sakit', 'permit' => 'Izin', 'alpha' => 'Tanpa Keterangan']),
                    Forms\Components\Textarea::make('teaching_note')
                        ->label('Jurnal / Catatan Guru')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(self::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start', 'desc')
            ->columns([
                
                // ========================================================
                // KOLOM TANGGAL (DENGAN QUICK EDIT MODAL)
                // ========================================================
                TextColumn::make('start')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Klik untuk mengubah tanggal/waktu')
                    ->action(
                        Tables\Actions\Action::make('quick_edit_tanggal')
                            ->modalHeading('Ubah Jadwal')
                            ->modalWidth('md')
                            ->fillForm(fn (Schedule $record): array => [
                                'start' => $record->start,
                                'end' => $record->end,
                            ])
                            ->form([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\DateTimePicker::make('start')
                                        ->label('Waktu Mulai')->seconds(false)->required(),
                                    Forms\Components\DateTimePicker::make('end')
                                        ->label('Waktu Selesai')->seconds(false)->required(),
                                ]),
                            ])
                            ->action(function (array $data, Schedule $record): void {
                                $record->update([
                                    'start' => $data['start'],
                                    'end' => $data['end'],
                                ]);
                            })
                    ),

                // ========================================================
                // KOLOM JAM (DENGAN QUICK EDIT MODAL)
                // ========================================================
                TextColumn::make('time_range')
                    ->label('Jam')
                    ->state(fn(Schedule $record) => ($record->start && $record->end) ? $record->start->format('H:i') . ' - ' . $record->end->format('H:i') : '-')
                    ->icon('heroicon-m-pencil-square')
                    ->tooltip('Klik untuk mengubah tanggal/waktu')
                    ->action(
                        Tables\Actions\Action::make('quick_edit_jam')
                            ->modalHeading('Ubah Jadwal')
                            ->modalWidth('md')
                            ->fillForm(fn (Schedule $record): array => [
                                'start' => $record->start,
                                'end' => $record->end,
                            ])
                            ->form([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\DateTimePicker::make('start')
                                        ->label('Waktu Mulai')->seconds(false)->required(),
                                    Forms\Components\DateTimePicker::make('end')
                                        ->label('Waktu Selesai')->seconds(false)->required(),
                                ]),
                            ])
                            ->action(function (array $data, Schedule $record): void {
                                $record->update([
                                    'start' => $data['start'],
                                    'end' => $data['end'],
                                ]);
                            })
                    ),

                TextColumn::make('teacherProfile.user.name')
                    ->label('Guru')
                    ->sortable()
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('booking.student_name')
                    ->label('Santri')
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('booking.method')
                    ->label('Metode')
                    ->badge()
                    ->colors(['info' => 'online', 'warning' => 'offline'])
                    ->formatStateUsing(fn(?string $state): string => $state ? strtoupper($state) : '-'),

                TextColumn::make('title')
                    ->label('Kegiatan')
                    ->limit(20)
                    ->searchable(),

                TextColumn::make('student_presence')
                    ->label('Absensi')
                    ->badge()
                    ->colors(['success' => 'present', 'warning' => 'permit', 'danger' => 'sick', 'gray' => 'alpha'])
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'present' => 'Hadir', 'sick' => 'Sakit', 'permit' => 'Izin', 'alpha' => 'Alpha', default => '-',
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors(['success' => 'completed', 'gray' => 'pending'])
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'completed' => 'Selesai', 'pending' => 'Belum', default => $state ?? '-',
                    }),
            ])
            ->filters([
                SelectFilter::make('teacher_profile_id')
                    ->label('Filter Guru')
                    ->searchable()
                    ->options(function () {
                        return \App\Models\TeacherProfile::with('user')
                            ->get()
                            ->mapWithKeys(function ($profile) {
                                return [$profile->id => $profile->user->name ?? 'Tanpa Nama'];
                            });
                    }),
                SelectFilter::make('status')
                    ->options(['pending' => 'Belum Mulai', 'completed' => 'Selesai'])
                    ->label('Status Kelas'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('cetak_langsung')
                    ->label('Download Excel / CSV')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function ($livewire) {
                        $query = $livewire->getFilteredTableQuery();

                        return response()->streamDownload(function () use ($query) {
                            $file = fopen('php://output', 'w');
                            fputs($file, "\xEF\xBB\xBF"); 
                            fputcsv($file, ['Tanggal', 'Jam', 'Nama Guru', 'Nama Santri', 'Metode', 'Kegiatan', 'Kehadiran', 'Status', 'Catatan Jurnal'], ';'); 

                            $query->cursor()->each(function ($row) use ($file) {
                                $kehadiran = match ($row->student_presence) {
                                    'present' => 'Hadir', 'sick' => 'Sakit', 'permit' => 'Izin', 'alpha' => 'Alpha', default => '-',
                                };
                                $statusKelas = match ($row->status) {
                                    'completed' => 'Selesai', 'pending' => 'Belum', default => '-',
                                };

                                fputcsv($file, [
                                    $row->start ? \Carbon\Carbon::parse($row->start)->format('d/m/Y') : '-',
                                    ($row->start && $row->end) ? \Carbon\Carbon::parse($row->start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($row->end)->format('H:i') : '-',
                                    $row->teacherProfile->user->name ?? '-',
                                    $row->booking->student_name ?? '-',
                                    strtoupper($row->booking->method ?? '-'),
                                    $row->title ?? '-',
                                    $kehadiran,
                                    $statusKelas,
                                    $row->teaching_note ?? '-',
                                ], ';');
                            });

                            fclose($file);
                        }, 'Data_Jadwal_Mengajar.csv');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('cetak_terpilih')
                        ->label('Download Baris Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                $file = fopen('php://output', 'w');
                                fputs($file, "\xEF\xBB\xBF");
                                fputcsv($file, ['Tanggal', 'Jam', 'Nama Guru', 'Nama Santri', 'Metode', 'Kegiatan', 'Kehadiran', 'Status', 'Catatan Jurnal'], ';');

                                foreach ($records as $row) {
                                    $kehadiran = match ($row->student_presence) {
                                        'present' => 'Hadir', 'sick' => 'Sakit', 'permit' => 'Izin', 'alpha' => 'Alpha', default => '-',
                                    };
                                    $statusKelas = match ($row->status) {
                                        'completed' => 'Selesai', 'pending' => 'Belum', default => '-',
                                    };

                                    fputcsv($file, [
                                        $row->start ? \Carbon\Carbon::parse($row->start)->format('d/m/Y') : '-',
                                        ($row->start && $row->end) ? \Carbon\Carbon::parse($row->start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($row->end)->format('H:i') : '-',
                                        $row->teacherProfile->user->name ?? '-',
                                        $row->booking->student_name ?? '-',
                                        strtoupper($row->booking->method ?? '-'),
                                        $row->title ?? '-',
                                        $kehadiran,
                                        $statusKelas,
                                        $row->teaching_note ?? '-',
                                    ], ';');
                                }
                                fclose($file);
                            }, 'Data_Jadwal_Terpilih.csv');
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}