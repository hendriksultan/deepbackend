<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamAttemptResource\Pages;
use App\Models\ExamAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Library Export Excel
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ExamAttemptResource extends Resource
{
    protected static ?string $model = ExamAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationLabel = 'Laporan Nilai';

    protected static ?string $pluralModelLabel = 'Laporan Hasil Ujian';

    protected static ?string $navigationGroup = 'Laporan Akademik';

    // Agar urut dari yang terbaru
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pengerjaan')
                    ->schema([
                        Forms\Components\TextInput::make('user_name')
                            ->label('Nama Siswa')
                            ->formatStateUsing(fn($record) => $record->user->name)
                            ->disabled(),

                        Forms\Components\TextInput::make('exam_title')
                            ->label('Judul Ujian')
                            ->formatStateUsing(fn($record) => $record->exam->title)
                            ->disabled(),

                        Forms\Components\TextInput::make('score')
                            ->label('Nilai Akhir')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('started_at')
                            ->label('Waktu Mulai')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('finished_at')
                            ->label('Waktu Selesai')
                            ->disabled(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Nama Siswa
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // 2. Judul Ujian
                Tables\Columns\TextColumn::make('exam.title')
                    ->label('Ujian')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                // 3. Nilai
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'info',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    }),

                // 4. Status Lulus
                Tables\Columns\TextColumn::make('status_lulus')
                    ->label('Keterangan')
                    ->badge()
                    ->state(fn(Model $record) => $record->score >= 70 ? 'LULUS' : 'REMEDIAL')
                    ->color(fn(string $state) => $state === 'LULUS' ? 'success' : 'danger'),

                // 5. Tanggal
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan Ujian
                Tables\Filters\SelectFilter::make('exam_id')
                    ->label('Filter Ujian')
                    ->relationship('exam', 'title')
                    ->searchable()
                    ->preload(),

                // Filter Tanggal
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->headerActions([
                // Tombol Export Excel
                ExportAction::make()
                    ->label('Download Laporan (Excel)')
                    ->color('success')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn() => 'Laporan_Ujian_' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('user.name')->heading('Nama Siswa'),
                                Column::make('exam.title')->heading('Judul Ujian'),
                                Column::make('score')->heading('Nilai'),
                                Column::make('created_at')->heading('Tanggal'),
                            ]),
                    ]),
            ])
            ->actions([
                // Aksi Lihat Detail
                Tables\Actions\Action::make('view_detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalContent(fn($record) => view('filament.teacher.attempts.detail', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

               // =======================================================
                // [BARU] TOMBOL DOWNLOAD SERTIFIKAT KHUSUS YANG LULUS
                // =======================================================
                Tables\Actions\Action::make('download_certificate')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->visible(fn ($record) => $record->score >= 70)
                    ->action(function ($record) {
                        
                        // [PERBAIKAN] Menambahkan izin 'isRemoteEnabled' agar QR Code bisa dimuat
                        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.exam', ['attempt' => $record])
                            ->setPaper('a4', 'landscape')
                            ->setOption('isRemoteEnabled', true);
                        
                        $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', $record->user->name);
                        $fileName = 'Sertifikat_Lulus_' . $safeName . '.pdf';
                        
                        return response()->streamDownload(function () use ($pdf) {
                            print($pdf->output());
                        }, $fileName);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // Matikan tombol "Buat Baru" karena ini laporan otomatis
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamAttempts::route('/'),
            // Kita tidak butuh page create/edit karena readonly
        ];
    }
}