<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArabicEvaluationResource\Pages;
use App\Models\ArabicEvaluation;
use App\Models\Booking;
use App\Models\TeacherProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ArabicEvaluationResource extends Resource
{
    protected static ?string $model = ArabicEvaluation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Evaluasi Bahasa Arab';
    protected static ?string $navigationGroup = 'Laporan Akademik';
    protected static ?string $pluralModelLabel = 'Evaluasi Bahasa Arab';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Form Evaluasi Bahasa Arab (Admin)')
                ->description('Admin dapat mengedit atau melihat semua data evaluasi dari seluruh pengajar.')
                ->schema([
                    // =========================================================
                    // FILTER SANTRI: Tampilkan semua santri Bahasa Arab + Nama Gurunya
                    // =========================================================
                    Forms\Components\Select::make('booking_id')
                        ->label('Pilih Santri (Kelas Bahasa Arab)')
                        ->options(function () {
                            return Booking::with('teacherProfile.user')
                                ->whereIn('status', ['active', 'approved'])
                                ->where('program_type', 'bahasa')
                                ->get()
                                ->mapWithKeys(function ($booking) {
                                    $teacherName = $booking->teacherProfile->user->name ?? 'Belum ada guru';
                                    return [$booking->id => $booking->student_name . ' (Guru: ' . $teacherName . ')'];
                                });
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\DatePicker::make('tanggal')
                        ->default(now())
                        ->required()
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('topik_materi')
                        ->label('Topik / Bab Materi')
                        ->required()
                        ->columnSpan(1),

                    Forms\Components\Fieldset::make('Metrik Penilaian')
                        ->schema([
                            Forms\Components\Select::make('nilai_kosakata')
                                ->label('Kosakata (Mufradat)')
                                ->options(['A' => 'A (Sangat Baik)', 'B' => 'B (Baik)', 'C' => 'C (Cukup)', 'D' => 'D (Kurang)']),

                            Forms\Components\Select::make('nilai_tata_bahasa')
                                ->label('Tata Bahasa (Nahwu/Shorof)')
                                ->options(['A' => 'A (Sangat Baik)', 'B' => 'B (Baik)', 'C' => 'C (Cukup)', 'D' => 'D (Kurang)']),

                            Forms\Components\Select::make('nilai_percakapan')
                                ->label('Praktik Bicara (Muhadatsah)')
                                ->options(['A' => 'A (Sangat Baik)', 'B' => 'B (Baik)', 'C' => 'C (Cukup)', 'D' => 'D (Kurang)']),
                        ])->columns(3),

                    Forms\Components\Textarea::make('catatan_guru')
                        ->label('Catatan & Evaluasi (Opsional)')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Santri')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking.teacherProfile.user.name')
                    ->label('Pengajar')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('topik_materi')
                    ->label('Topik')
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('nilai_kosakata')
                    ->label('Kosakata')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('nilai_tata_bahasa')
                    ->label('Nahwu')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('nilai_percakapan')
                    ->label('Kalam')
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
            // [MODIFIKASI] HEADER ACTIONS: EXPORT EXCEL DENGAN FILTER POP-UP
            // =================================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel Siap Cetak')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Export Laporan Bahasa Arab')
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
                        
                        $fileName = 'Laporan_BahasaArab_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate, $teacherId) {
                            $query = \App\Models\ArabicEvaluation::with(['booking.teacherProfile.user'])->orderBy('tanggal', 'asc');

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
                            $html .= '<td colspan="8" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN EVALUASI BAHASA ARAB SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="8" style="text-align: center; font-size: 12px; border: none;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="8" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . $guruText . '</td>';
                            $html .= '</tr>';

                            // --- HEADER TABEL ---
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Guru</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Topik Materi</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Kosakata</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nahwu/Shorof</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Muhadatsah</th>';
                            $html .= '<th style="width: 350px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Guru</th>';
                            $html .= '</tr>';

                            // --- ISI DATA ---
                            if ($evaluasi->isEmpty()) {
                                $html .= '<tr><td colspan="8" style="text-align: center; border: .5pt solid #000000;">Tidak ada data pada periode ini.</td></tr>';
                            } else {
                                foreach ($evaluasi as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaGuru = htmlspecialchars($row->booking->teacherProfile->user->name ?? 'Tanpa Guru');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $topik = htmlspecialchars($row->topik_materi ?? '-');
                                    $catatan = htmlspecialchars($row->catatan_guru ?? '-');

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaGuru . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $topik . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_kosakata ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_tata_bahasa ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_percakapan ?? '-') . '</td>';
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
            ])
            // =================================================================
            // [MODIFIKASI] BULK ACTIONS: EXPORT EXCEL DATA TERPILIH
            // =================================================================
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('export_terpilih')
                        ->label('Export Excel Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $fileName = 'Laporan_BahasaArab_Terpilih_' . date('Ymd_His') . '.xls';

                            return response()->streamDownload(function () use ($records) {
                                $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                                $html .= '<head><meta charset="utf-8"></head><body>';
                                $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                                $html .= '<tr>';
                                $html .= '<td colspan="8" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN EVALUASI BAHASA ARAB SANTRI</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="8" style="text-align: center; font-size: 12px; border: none;">Periode: Data Terpilih</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="8" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: Data Terpilih</td>';
                                $html .= '</tr>';

                                $html .= '<tr>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Guru</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Topik Materi</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Kosakata</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nahwu/Shorof</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Muhadatsah</th>';
                                $html .= '<th style="width: 350px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Guru</th>';
                                $html .= '</tr>';

                                foreach ($records as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaGuru = htmlspecialchars($row->booking->teacherProfile->user->name ?? 'Tanpa Guru');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $topik = htmlspecialchars($row->topik_materi ?? '-');
                                    $catatan = htmlspecialchars($row->catatan_guru ?? '-');

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaGuru . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $topik . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_kosakata ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_tata_bahasa ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai_percakapan ?? '-') . '</td>';
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
            'index' => Pages\ListArabicEvaluations::route('/'),
            'create' => Pages\CreateArabicEvaluation::route('/create'),
            'edit' => Pages\EditArabicEvaluation::route('/{record}/edit'),
        ];
    }
}