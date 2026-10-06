<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\MutabaahTahsinResource\Pages;
use App\Models\MutabaahTahsin;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MutabaahTahsinResource extends Resource
{
    protected static ?string $model = MutabaahTahsin::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Evaluasi Tahsin Santri';
    
    // ====================================================
    // [BARU] Mengubah teks singular agar tombol menjadi "Buat Materi Pembelajaran"
    // ====================================================
    protected static ?string $modelLabel = 'Evaluasi Tahsin';
    protected static ?string $navigationGroup = 'Evaluasi Belajar';
    protected static ?string $pluralModelLabel = 'Evaluasi Tahsin Santri';
    protected static ?int $navigationSort = 1;

    // FITUR KEAMANAN: Asatidz hanya melihat data miliknya sendiri
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
        // Ambil ID Guru yang sedang login
        $teacherProfile = \App\Models\TeacherProfile::where('user_id', Auth::id())->first();
        $teacherId = $teacherProfile ? $teacherProfile->id : 0;

        return $form
            ->schema([
                Forms\Components\Section::make('Formulir Penilaian Tahsin')
                    ->description('Silakan isi perkembangan bacaan santri hari ini.')
                    ->schema([
                        // Pilih Santri
                        Forms\Components\Select::make('booking_id')
                            ->label('Nama Santri (Kelas Tahsin)')
                            ->options(function () use ($teacherId) {
                                return Booking::where('teacher_profile_id', $teacherId)
                                    ->whereIn('status', ['active', 'approved'])
                                    ->where('program_type', 'tahsin') 
                                    ->get()
                                    ->mapWithKeys(function ($booking) {
                                        return [$booking->id => $booking->student_name];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->required(),

                        // Level Pembelajaran
                        Forms\Components\Select::make('jilid')
                            ->label('Materi / Jilid')
                            ->options([
                                'Pra-Tahsin' => 'Pra-Tahsin (Pengenalan Huruf)',
                                'Jilid 1' => 'Jilid 1',
                                'Jilid 2' => 'Jilid 2',
                                'Jilid 3' => 'Jilid 3',
                                'Jilid 4' => 'Jilid 4',
                                'Jilid 5' => 'Jilid 5',
                                'Jilid 6' => 'Jilid 6',
                                'Al-Quran' => 'Al-Quran (Talaqqi)',
                            ])
                            ->required()
                            ->live(),

                        // Kondisional: Muncul jika BUKAN Al-Quran
                        Forms\Components\TextInput::make('halaman')
                            ->label('Halaman')
                            ->numeric()
                            ->visible(fn(Get $get) => $get('jilid') !== 'Al-Quran' && $get('jilid') !== null),

                        // Kondisional: Muncul jika AL-QURAN
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('surah')->label('Surah'),
                                Forms\Components\TextInput::make('ayat')->label('Ayat'),
                            ])
                            ->visible(fn(Get $get) => $get('jilid') === 'Al-Quran'),

                        // Penilaian
                        Forms\Components\Select::make('nilai')
                            ->options([
                                'Mumtaz' => 'Mumtaz (Istimewa)',
                                'Jayyid Jiddan' => 'Jayyid Jiddan (Sangat Baik)',
                                'Jayyid' => 'Jayyid (Baik)',
                                'Maqbul' => 'Maqbul (Cukup)',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_tajwid')
                            ->label('Koreksi Tajwid')
                            ->placeholder('Contoh: Ghunnah kurang tahan, Mad wajib kurang panjang.')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),

                Tables\Columns\TextColumn::make('booking.student_name')
                    ->label('Santri')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('jilid')
                    ->badge()
                    ->color('info'),

                // Custom Column untuk menggabungkan info Halaman/Ayat
                Tables\Columns\TextColumn::make('pencapaian')
                    ->label('Pencapaian (Hal/Ayat)')
                    ->state(function (MutabaahTahsin $record): string {
                        if ($record->jilid === 'Al-Quran') {
                            return "{$record->surah} : {$record->ayat}";
                        }
                        return "Hal. " . ($record->halaman ?? '-');
                    }),

                Tables\Columns\TextColumn::make('nilai')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A', 'Mumtaz' => 'success',
                        'B', 'Jayyid Jiddan', 'Jayyid' => 'info',
                        'C', 'Maqbul' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                // Filter berdasarkan Tanggal
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
            // [MODIFIKASI] HEADER ACTIONS: EXPORT EXCEL RAPI (.XLS)
            // =================================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Export Laporan Tahsin')
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
                        
                        $fileName = 'Laporan_Tahsin_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate) {
                            $teacherProfile = \App\Models\TeacherProfile::with('user')->where('user_id', Auth::id())->first();
                            $teacherId = $teacherProfile?->id;
                            $namaGuru = $teacherProfile?->user?->name ?? 'Asatidz';

                            $query = \App\Models\MutabaahTahsin::with(['booking'])
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
                            $html .= '<td colspan="6" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHSIN SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="6" style="text-align: center; font-size: 12px; border: none;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="6" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . htmlspecialchars($namaGuru) . '</td>';
                            $html .= '</tr>';

                            // Header Tabel dengan ketebalan garis .5pt (6 Kolom karena guru tidak perlu melihat namanya sendiri di setiap baris)
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid / Kategori</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Pencapaian (Hal/Surah)</th>';
                            $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                            $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Tajwid</th>';
                            $html .= '</tr>';

                            if ($evaluasi->isEmpty()) {
                                $html .= '<tr><td colspan="6" style="text-align: center; border: .5pt solid #000000;">Tidak ada data pada periode ini.</td></tr>';
                            } else {
                                foreach ($evaluasi as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
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
            // [MODIFIKASI] BULK ACTIONS: EXPORT EXCEL DATA TERPILIH
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
                                $teacherProfile = \App\Models\TeacherProfile::with('user')->where('user_id', Auth::id())->first();
                                $namaGuru = $teacherProfile?->user?->name ?? 'Asatidz';

                                $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                                $html .= '<head><meta charset="utf-8"></head><body>';
                                $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                                $html .= '<tr>';
                                $html .= '<td colspan="6" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHSIN SANTRI</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="6" style="text-align: center; font-size: 12px; border: none;">Periode: Data Terpilih</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="6" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . htmlspecialchars($namaGuru) . '</td>';
                                $html .= '</tr>';

                                $html .= '<tr>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jilid / Kategori</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Pencapaian (Hal/Surah)</th>';
                                $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                                $html .= '<th style="width: 400px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan Tajwid</th>';
                                $html .= '</tr>';

                                foreach ($records as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
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