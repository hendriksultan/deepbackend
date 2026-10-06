<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\GuruEvaluasiIqraResource\Pages;
use App\Models\EvaluasiIqra;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GuruEvaluasiIqraResource extends Resource
{
    protected static ?string $model = EvaluasiIqra::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Evaluasi Iqra';
    protected static ?string $modelLabel = 'Evaluasi Iqra';
    protected static ?string $navigationGroup = 'Evaluasi Belajar';
    protected static ?string $pluralModelLabel = 'Evaluasi Iqra';

    // FITUR KEAMANAN: Guru hanya melihat data anak didiknya sendiri
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('booking', function ($query) {
            $teacherProfile = \App\Models\TeacherProfile::where('user_id', Auth::id())->first();
            if ($teacherProfile) {
                $query->where('teacher_profile_id', $teacherProfile->id);
            }
        });
    }

    public static function form(Form $form): Form
    {
        $teacherProfile = \App\Models\TeacherProfile::where('user_id', Auth::id())->first();
        $teacherId = $teacherProfile ? $teacherProfile->id : 0;

        return $form
            ->schema([
                Forms\Components\Section::make('Form Evaluasi Iqra')
                    ->schema([
                        Forms\Components\Select::make('booking_id')
                            ->label('Pilih Santri (Kelas Iqra)')
                            ->options(function () use ($teacherId) {
                                return Booking::where('teacher_profile_id', $teacherId)
                                    ->whereIn('status', ['active', 'approved'])
                                    ->where('program_type', 'iqra') 
                                    ->get()
                                    ->mapWithKeys(function ($booking) {
                                        return [$booking->id => $booking->student_name];
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
                            ->label('Catatan Khusus (Opsional)')
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
                    ->label('Santri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jilid')
                    ->label('Jilid')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn(string $state): string => 'Jilid ' . $state),
                Tables\Columns\TextColumn::make('halaman')->label('Halaman'),
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // =========================================================
            // [MODIFIKASI] HEADER EXPORT: POP-UP FILTER TANGGAL (.XLS)
            // =========================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->modalHeading('Export Laporan Siap Cetak')
                    ->modalDescription('Silakan pilih rentang waktu data yang ingin diunduh. Kosongkan jika ingin mengunduh semua data Anda.')
                    ->modalSubmitActionLabel('Download Excel')
                    ->form([
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
                        
                        $fileName = 'Laporan_Evaluasi_Iqra_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate) {
                            $teacherId = \App\Models\TeacherProfile::where('user_id', Auth::id())->first()?->id;
                            
                            $query = EvaluasiIqra::with(['booking.teacherProfile.user'])
                                ->whereHas('booking', fn($q) => $q->where('teacher_profile_id', $teacherId))
                                ->orderBy('tanggal', 'asc');

                            if ($startDate) {
                                $query->whereDate('tanggal', '>=', $startDate);
                            }
                            if ($endDate) {
                                $query->whereDate('tanggal', '<=', $endDate);
                            }

                            $evaluasi = $query->get();

                            $periodeText = 'Semua Waktu';
                            if ($startDate && $endDate) {
                                $periodeText = \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y') . ' s/d ' . \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y');
                            } elseif ($startDate) {
                                $periodeText = 'Sejak ' . \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y');
                            } elseif ($endDate) {
                                $periodeText = 'Hingga ' . \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y');
                            }

                            $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                            $html .= '<head><meta charset="utf-8"></head><body>';
                            $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN EVALUASI IQRA SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';

                            // Posisi "Nama Guru" diletakkan sebelum "Nama Santri"
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Guru</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Halaman</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                            $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Guru</th>';
                            $html .= '</tr>';

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
            // =========================================================
            // [MODIFIKASI] BULK EXPORT TERPILIH: FORMAT EXCEL RAPI (.XLS)
            // =========================================================
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('export_terpilih')
                        ->label('Export Excel Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $fileName = 'Laporan_Iqra_Terpilih_' . date('Ymd_His') . '.xls';

                            return response()->streamDownload(function () use ($records) {
                                $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                                $html .= '<head><meta charset="utf-8"></head><body>';
                                $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN EVALUASI IQRA SANTRI</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Periode: Data Terpilih</td>';
                                $html .= '</tr>';

                                $html .= '<tr>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Guru</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Halaman</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                                $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Guru</th>';
                                $html .= '</tr>';

                                foreach ($records as $row) {
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

                                $html .= '</table></body></html>';

                                echo $html;
                            }, $fileName, [
                                'Content-Type' => 'application/vnd.ms-excel',
                                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                            ]);
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
            'index' => Pages\ListGuruEvaluasiIqras::route('/'),
            'create' => Pages\CreateGuruEvaluasiIqra::route('/create'),
            'edit' => Pages\EditGuruEvaluasiIqra::route('/{record}/edit'),
        ];
    }
}