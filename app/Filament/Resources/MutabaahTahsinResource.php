<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MutabaahTahsinResource\Pages;
use App\Models\MutabaahTahsin;
use App\Models\Booking;
use App\Models\TeacherProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class MutabaahTahsinResource extends Resource
{
    protected static ?string $model = MutabaahTahsin::class;

    // Ikon berbeda agar admin tahu ini menu monitoring
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Laporan Tahsin';
    protected static ?string $pluralModelLabel = 'Data Mutabaah Tahsin';
    protected static ?string $navigationGroup = 'Laporan Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Tahsin Santri')
                    ->schema([
                        Forms\Components\Select::make('booking_id')
                            ->label('Nama Santri (Kelas Tahsin)')
                            ->options(function () {
                                return Booking::with('teacherProfile.user')
                                    ->whereIn('status', ['active', 'approved'])
                                    ->where('program_type', 'tahsin')
                                    ->get()
                                    ->mapWithKeys(function ($booking) {
                                        return [$booking->id => $booking->student_name . ' - ' . ($booking->teacherProfile->user->name ?? 'Tanpa Asatidz')];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('tanggal')
                            ->required(),

                        Forms\Components\Select::make('jilid')
                            ->options([
                                'Pra-Tahsin' => 'Pra-Tahsin',
                                'Jilid 1' => 'Jilid 1',
                                'Jilid 2' => 'Jilid 2',
                                'Jilid 3' => 'Jilid 3',
                                'Jilid 4' => 'Jilid 4',
                                'Jilid 5' => 'Jilid 5',
                                'Jilid 6' => 'Jilid 6',
                                'Al-Quran' => 'Al-Quran',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('halaman')
                            ->numeric()
                            ->visible(fn(Get $get) => $get('jilid') !== 'Al-Quran' && $get('jilid') !== null),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('surah')->label('Nama Surah'),
                                Forms\Components\TextInput::make('ayat')->label('Ayat Ke-'),
                            ])
                            ->visible(fn(Get $get) => $get('jilid') === 'Al-Quran'),

                        Forms\Components\Select::make('nilai')
                            ->options(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_tajwid')
                            ->label('Catatan Tajwid / Evaluasi')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable()->weight('bold'),
                
                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Santri')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking.teacherProfile.user.name')
                    ->label('Asatidz')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jilid')
                    ->label('Jilid/Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nilai')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')->label('Diinput Pada')->dateTime()->toggleable(isToggledHiddenByDefault: true),
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
            // =================================================================
            // [BARU] HEADER ACTIONS: EXPORT EXCEL KHUSUS ADMIN (FILTER ASATIDZ)
            // =================================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel Siap Cetak')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Export Laporan Tahsin')
                    ->modalDescription('Silakan pilih rentang waktu dan Asatidz tertentu. Kosongkan pilihan Asatidz jika ingin mengunduh laporan secara menyeluruh.')
                    ->modalSubmitActionLabel('Download Excel')
                    ->form([
                        Forms\Components\Select::make('teacher_profile_id')
                            ->label('Filter Berdasarkan Asatidz (Opsional)')
                            ->options(TeacherProfile::with('user')->get()->pluck('user.name', 'id'))
                            ->searchable()
                            ->preload()
                            ->placeholder('Semua Asatidz'),
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
                        
                        $fileName = 'Laporan_Tahsin_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate, $teacherId) {
                            $query = \App\Models\MutabaahTahsin::with(['booking.teacherProfile.user'])->orderBy('tanggal', 'asc');

                            if ($startDate) {
                                $query->whereDate('tanggal', '>=', $startDate);
                            }
                            if ($endDate) {
                                $query->whereDate('tanggal', '<=', $endDate);
                            }
                            if ($teacherId) {
                                $query->whereHas('booking', function($q) use ($teacherId) {
                                    $q->where('teacher_profile_id', $teacherId);
                                });
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

                            $guruText = 'Semua Asatidz';
                            if ($teacherId) {
                                $guruText = TeacherProfile::with('user')->find($teacherId)?->user?->name ?? 'Tidak Ditemukan';
                            }

                            $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                            $html .= '<head><meta charset="utf-8"></head><body>';
                            $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHSIN SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . $guruText . '</td>';
                            $html .= '</tr>';

                            // Header Tabel dengan ketebalan garis .5pt
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Asatidz</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid / Kategori</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Pencapaian (Hal/Surah)</th>';
                            $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                            $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Tajwid</th>';
                            $html .= '</tr>';

                            if ($evaluasi->isEmpty()) {
                                $html .= '<tr><td colspan="7" style="text-align: center; border: .5pt solid #000000;">Tidak ada data pada periode ini.</td></tr>';
                            } else {
                                foreach ($evaluasi as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaGuru = htmlspecialchars($row->booking->teacherProfile->user->name ?? 'Tanpa Asatidz');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $catatan = htmlspecialchars($row->catatan_tajwid ?? '-');
                                    
                                    // Logika Cerdas untuk Halaman atau Surah
                                    $pencapaian = '-';
                                    if ($row->jilid === 'Al-Quran') {
                                        $surah = htmlspecialchars($row->surah ?? '');
                                        $ayat = htmlspecialchars($row->ayat ?? '');
                                        $pencapaian = trim("Surah $surah Ayat $ayat");
                                    } else {
                                        $pencapaian = "Halaman " . htmlspecialchars($row->halaman ?? '');
                                    }

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaGuru . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . ($row->jilid ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $pencapaian . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai ?? '-') . '</td>';
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
            // =================================================================
            // [BARU] BULK ACTIONS: EXPORT EXCEL DATA TERPILIH
            // =================================================================
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('export_terpilih')
                        ->label('Export Excel Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $fileName = 'Laporan_Tahsin_Terpilih_' . date('Ymd_His') . '.xls';

                            return response()->streamDownload(function () use ($records) {
                                $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                                $html .= '<head><meta charset="utf-8"></head><body>';
                                $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHSIN SANTRI</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none;">Periode: Data Terpilih</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: Data Terpilih</td>';
                                $html .= '</tr>';

                                $html .= '<tr>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Asatidz</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid / Kategori</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Pencapaian (Hal/Surah)</th>';
                                $html .= '<th style="width: 100px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                                $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Tajwid</th>';
                                $html .= '</tr>';

                                foreach ($records as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaGuru = htmlspecialchars($row->booking->teacherProfile->user->name ?? 'Tanpa Asatidz');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $catatan = htmlspecialchars($row->catatan_tajwid ?? '-');
                                    
                                    $pencapaian = '-';
                                    if ($row->jilid === 'Al-Quran') {
                                        $surah = htmlspecialchars($row->surah ?? '');
                                        $ayat = htmlspecialchars($row->ayat ?? '');
                                        $pencapaian = trim("Surah $surah Ayat $ayat");
                                    } else {
                                        $pencapaian = "Halaman " . htmlspecialchars($row->halaman ?? '');
                                    }

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaGuru . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . ($row->jilid ?? '-') . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $pencapaian . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . ($row->nilai ?? '-') . '</td>';
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
            'index' => Pages\ListMutabaahTahsins::route('/'),
            'create' => Pages\CreateMutabaahTahsin::route('/create'),
            'edit' => Pages\EditMutabaahTahsin::route('/{record}/edit'),
        ];
    }
}