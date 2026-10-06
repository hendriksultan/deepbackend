<?php

namespace App\Filament\Teacher\Resources\ExamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

// --- IMPORT UNTUK EXPORT EXCEL ---
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class AttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'attempts';

    protected static ?string $title = 'Riwayat Pengerjaan Siswa';

    protected static ?string $modelLabel = 'Nilai Siswa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Nama Siswa')
                    ->disabled(),

                Forms\Components\TextInput::make('score')
                    ->label('Nilai Akhir')
                    ->required()
                    ->numeric()
                    ->maxValue(100),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state === null => 'gray',
                        $state >= 90 => 'success',
                        $state >= 75 => 'info',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn($state) => $state === null ? 'Belum Selesai' : $state),

                // --- 1. TAMBAHAN KOLOM KETERANGAN LULUS / MENGULANG ---
                Tables\Columns\TextColumn::make('status')
                    ->label('Keterangan')
                    ->getStateUsing(function (Model $record) {
                        if ($record->score === null) return 'Sedang Proses';
                        return $record->score >= 70 ? 'Lulus' : 'Mengulang'; // Sesuaikan 70 dengan KKM Anda
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Lulus' => 'success',
                        'Mengulang' => 'danger',
                        'Sedang Proses' => 'warning',
                    })
                    ->icon(fn(string $state): string|null => match ($state) {
                        'Lulus' => 'heroicon-m-check-circle',
                        'Mengulang' => 'heroicon-m-x-circle',
                        'Sedang Proses' => 'heroicon-m-clock',
                        default => null,
                    }),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime('d M H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Selesai')
                    ->dateTime('d M H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->state(function (Model $record) {
                        if ($record->started_at && $record->finished_at) {
                            return $record->started_at->diffForHumans($record->finished_at, true);
                        }
                        return '-';
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('passed')
                    ->label('Lulus (Nilai >= 70)')
                    ->query(fn($query) => $query->where('score', '>=', 70)),
                Tables\Filters\Filter::make('failed')
                    ->label('Mengulang (Nilai < 70)')
                    ->query(fn($query) => $query->whereNotNull('score')->where('score', '<', 70)),
            ])

            // --- HEADER ACTIONS (EXPORT EXCEL) ---
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->color('success')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn() => 'Nilai_Ujian_' . date('d-m-Y'))
                            ->withColumns([
                                Column::make('user.name')->heading('Nama Siswa'),
                                Column::make('score')->heading('Nilai'),
                                Column::make('started_at')->heading('Waktu Mulai'),
                                Column::make('finished_at')->heading('Waktu Selesai'),
                            ]),
                    ]),
            ])

            // --- ROW ACTIONS (LIHAT DETAIL, EDIT, HAPUS, ULANG) ---
            ->actions([
                Tables\Actions\Action::make('view_answers')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading('Detail Jawaban Siswa')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn(Model $record) => view('filament.teacher.attempts.detail', ['record' => $record])),

                Tables\Actions\EditAction::make()
                    ->label('Koreksi')
                    ->icon('heroicon-o-pencil-square'),

                // --- 2. TAMBAHAN TOMBOL ULANGI UJIAN ---
                Tables\Actions\Action::make('ulangi_ujian')
                    ->label('Izinkan Ulang')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    // Tombol ini HANYA MUNCUL jika nilai sudah keluar dan di bawah 70
                    ->visible(fn(Model $record): bool => $record->score !== null && $record->score < 70)
                    ->requiresConfirmation()
                    ->modalHeading('Izinkan Ulang Ujian')
                    ->modalDescription('Tindakan ini akan menghapus nilai saat ini dan mereset status, sehingga siswa dapat mengerjakan ulang ujian dari awal. Yakin ingin melanjutkan?')
                    ->modalSubmitActionLabel('Ya, Izinkan')
                    ->action(fn(Model $record) => $record->delete())
                    ->successNotificationTitle('Data di-reset. Siswa kini dapat mengulang ujian.'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->modalHeading('Hapus Riwayat')
                    ->modalDescription('Data nilai siswa akan dihapus permanen.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
