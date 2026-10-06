<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluasiIqraResource\Pages;
use App\Models\EvaluasiIqra;
use App\Models\Booking;
use App\Models\TeacherProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class EvaluasiIqraResource extends Resource
{
    protected static ?string $model = EvaluasiIqra::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Evaluasi Iqra';
    protected static ?string $navigationGroup = 'Laporan Akademik';
    protected static ?string $pluralModelLabel = 'Evaluasi Iqra';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Evaluasi Iqra')
                    ->schema([
                        Forms\Components\Select::make('booking_id')
                            ->label('Santri (Kelas Iqra)')
                            ->options(function () {
                                return Booking::whereIn('status', ['active', 'approved'])
                                    ->where('program_type', 'iqra')
                                    ->get()
                                    ->mapWithKeys(function ($booking) {
                                        return [$booking->id => $booking->student_name . ' - ' . ($booking->teacherProfile->user->name ?? 'Tanpa Guru')];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('jilid')
                            ->options([
                                '1' => 'Iqra Jilid 1',
                                '2' => 'Iqra Jilid 2',
                                '3' => 'Iqra Jilid 3',
                                '4' => 'Iqra Jilid 4',
                                '5' => 'Iqra Jilid 5',
                                '6' => 'Iqra Jilid 6',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('halaman')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Forms\Components\Select::make('nilai')
                            ->options([
                                'A' => 'A (Sangat Lancar)',
                                'B' => 'B (Lancar)',
                                'C' => 'C (Cukup / Mengulang)',
                                'D' => 'D (Kurang)',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_guru')
                            ->label('Catatan dari Guru')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jilid')
                    ->label('Jilid')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn(string $state): string => 'Jilid ' . $state),
                Tables\Columns\TextColumn::make('halaman')
                    ->label('Halaman'),
                Tables\Columns\TextColumn::make('nilai')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                Filter::make('tanggal_evaluasi')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['dari_tanggal'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date))
                            ->when($data['sampai_tanggal'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date));
                    })
            ])
            // =================================================================
            // [MODIFIKASI] EXPORT EXCEL KHUSUS ADMIN DENGAN FILTER GURU
            // =================================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel Siap Cetak')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Export Laporan Siap Cetak')
                    ->modalDescription('Silakan pilih rentang waktu dan guru tertentu. Kosongkan pilihan guru jika ingin mengunduh laporan seluruh guru.')
                    ->modalSubmitActionLabel('Download Excel')
                    ->form([
                        Forms\Components\Select::make('teacher_profile_id')
                            ->label('Filter Berdasarkan Guru (Opsional)')
                            ->options(TeacherProfile::with('user')->get()->pluck('user.name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder('Semua Guru'),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Dari Tanggal (Mulai)')
                            ->placeholder('Pilih tanggal awal'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Sampai Tanggal (Akhir)')
                            ->placeholder('Pilih tanggal akhir'),
                    ])
                    ->action(function (array $data) {
                        $startDate = $data['start_date'] ?? null;
                        $endDate = $data['end_date'] ?? null;
                        $teacherId = $data['teacher_profile_id'] ?? null;
                        
                        $fileName = 'Laporan_Evaluasi_Iqra_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate, $teacherId) {
                            $query = \App\Models\EvaluasiIqra::with(['booking.teacherProfile.user'])->orderBy('tanggal', 'asc');

                            // Menerapkan Filter Tanggal
                            if ($startDate) {
                                $query->whereDate('tanggal', '>=', $startDate);
                            }
                            if ($endDate) {
                                $query->whereDate('tanggal', '<=', $endDate);
                            }

                            // Menerapkan Filter Guru (Jika Admin Memilih)
                            if ($teacherId) {
                                $query->whereHas('booking', function($q) use ($teacherId) {
                                    $q->where('teacher_profile_id', $teacherId);
                                });
                            }

                            $evaluasi = $query->get();

                            // Merangkai Teks Periode
                            $periodeText = 'Semua Waktu';
                            if ($startDate && $endDate) {
                                $periodeText = \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y');
                            } elseif ($startDate) {
                                $periodeText = 'Sejak ' . \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y');
                            } elseif ($endDate) {
                                $periodeText = 'Hingga ' . \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y');
                            }

                            // Merangkai Teks Guru
                            $guruText = 'Semua Guru';
                            if ($teacherId) {
                                $namaGuruDipilih = TeacherProfile::with('user')->find($teacherId)?->user?->name;
                                $guruText = $namaGuruDipilih ?? 'Tidak Ditemukan';
                            }

                            $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                            $html .= '<head><meta charset="utf-8"></head><body>';
                            $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                            // --- BARIS JUDUL LAPORAN ---
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN EVALUASI IQRA SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . $guruText . '</td>';
                            $html .= '</tr>';

                            // --- HEADER TABEL ---
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Guru</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Halaman</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                            $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Guru</th>';
                            $html .= '</tr>';

                            // --- ISI DATA ---
                            if ($evaluasi->isEmpty()) {
                                $html .= '<tr><td colspan="7" style="text-align: center; border: .5pt solid #000000;">Tidak ada data pada periode ini.</td></tr>';
                            } else {
                                foreach ($evaluasi as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaGuru = htmlspecialchars($row->booking->teacherProfile->user->name ?? 'Tanpa Guru');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $catatan = htmlspecialchars($row->catatan_guru ?? '-');

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaGuru . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">Jilid ' . $row->jilid . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $row->halaman . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . $row->nilai . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $catatan . '</td>';
                                    $html .= '</tr>';
                                }
                            }

                            $html .= '</table></body></html>';

                            echo $html;

                        }, $fileName, [
                            'Content-Type' => 'application/vnd.ms-excel',
                            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                        ]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluasiIqras::route('/'),
            'create' => Pages\CreateEvaluasiIqra::route('/create'),
            'edit' => Pages\EditEvaluasiIqra::route('/{record}/edit'),
        ];
    }
}