<?php

namespace App\Filament\Teacher\Resources;

use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Carbon\Carbon;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Support\HtmlString;

class TeachingHistoryResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Riwayat Mengajar';
    protected static ?string $pluralModelLabel = 'Arsip Riwayat Mengajar';
    protected static ?string $navigationGroup = 'Akademik'; 
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $teacherId = auth()->user()->teacherProfile->id ?? 0;
        return $query->where('teacher_profile_id', $teacherId);
    }

    public static function canCreate(): bool { return false; }
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool { return false; }
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start')
                    ->label('Tgl & Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->default('-') // Kebal Null
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Materi / Halaqoh')
                    ->searchable()
                    ->default('-')
                    ->limit(25),

                Tables\Columns\TextColumn::make('booking.method')
                    ->label('Metode')
                    ->badge()
                    ->colors([
                        'info' => 'online',
                        'warning' => 'offline',
                    ])
                    // [PERBAIKAN] Tambah ?string dan pengecekan if agar tidak 500
                    ->formatStateUsing(fn (?string $state): string => $state ? strtoupper($state) : '-'),

                Tables\Columns\TextColumn::make('student_presence')
                    ->label('Kehadiran Santri')
                    ->badge()
                    ->colors([
                        'success' => 'present',
                        'warning' => 'permit',
                        'danger' => 'sick',
                        'gray' => 'alpha',
                    ])
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        'alpha' => 'Alpha',
                        default => 'Belum Absen',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'completed',
                        'gray' => 'pending',
                    ])
                    // [PERBAIKAN] Tambah ?string
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'completed' => 'Selesai',
                        'pending' => 'Menunggu',
                        default => $state ?? '-',
                    }),
            ])
            ->defaultSort('start', 'desc') 
            ->filters([
                Filter::make('tanggal')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start', '<=', $date),
                            );
                    }),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'completed' => 'Selesai',
                        'pending' => 'Belum / Menunggu',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Jurnal')
                    ->modalHeading('Detail Riwayat Mengajar'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Kelas')->schema([
                    TextEntry::make('start')
                        ->label('Waktu Mulai')
                        ->dateTime('l, d F Y - H:i'),
                    TextEntry::make('title')
                        ->label('Materi / Halaqoh')
                        ->default('-'), // Kebal Null
                    TextEntry::make('booking.student_name')
                        ->label('Nama Santri')
                        ->default('Data Santri Terhapus/Kosong'), // Kebal Null
                    TextEntry::make('booking.method')
                        ->label('Metode Kelas')
                        // [PERBAIKAN] Tambah ?string agar tidak meledak saat null
                        ->formatStateUsing(fn (?string $state) => $state ? strtoupper($state) : '-'),
                ])->columns(2),

                Section::make('Laporan Mengajar')->schema([
                    TextEntry::make('student_presence')
                        ->label('Kehadiran Santri')
                        ->badge()
                        ->color(fn (?string $state): string => match ($state) {
                            'present' => 'success',
                            'sick' => 'warning',
                            'permit' => 'warning',
                            'alpha' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn (?string $state): string => match ($state) {
                            'present' => 'Hadir',
                            'sick' => 'Sakit',
                            'permit' => 'Izin',
                            'alpha' => 'Alpha',
                            default => 'Belum Absen',
                        }),
                    TextEntry::make('status')
                        ->label('Status Kelas')
                        ->badge()
                        // [PERBAIKAN] Tambah ?string
                        ->color(fn (?string $state): string => match ($state) { 
                            'completed' => 'success',
                            'pending' => 'gray',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn (?string $state): string => match ($state) { 
                            'completed' => 'Selesai',
                            'pending' => 'Menunggu',
                            default => $state ?? '-',
                        }),
                    TextEntry::make('teaching_note')
                        ->label('Jurnal / Catatan Mengajar')
                        ->columnSpanFull()
                        ->html()
                        // [PERBAIKAN] Pengecekan aman untuk catatan
                        ->state(fn ($record) => $record->teaching_note ? new HtmlString($record->teaching_note) : new HtmlString('<i>Tidak ada catatan jurnal.</i>')),
                ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Teacher\Resources\TeachingHistoryResource\Pages\ManageTeachingHistories::route('/'),
        ];
    }
}