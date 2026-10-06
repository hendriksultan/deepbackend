<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\GuruMutabaahResource\Pages;
use App\Models\Mutabaah;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GuruMutabaahResource extends Resource
{
    protected static ?string $model = Mutabaah::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Evaluasi Hafalan Santri';
    
    // ====================================================
    // [BARU] Mengubah teks singular agar tombol menjadi "Buat Materi Pembelajaran"
    // ====================================================
    protected static ?string $modelLabel = 'Evaluasi Hafalan';
    protected static ?string $navigationGroup = 'Evaluasi Belajar';
    protected static ?string $pluralModelLabel = 'Evaluasi Hafalan Santri';

    // FITUR KEAMANAN: Guru hanya melihat data miliknya sendiri
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
                Forms\Components\Section::make('Form Setoran')
                    ->schema([
                        // === PERBAIKAN PENTING DISINI ===
                        // Menggunakan ->get() dan ->mapWithKeys() untuk custom label
                        Forms\Components\Select::make('booking_id')
                            ->label('Pilih Santri (Kelas Tahfidz)')
                            ->options(function () use ($teacherId) {
                                return Booking::where('teacher_profile_id', $teacherId)
                                    ->whereIn('status', ['active', 'approved'])
                                    ->where('program_type', 'tahfidz') // <--- FILTER HANYA TAHFIDZ
                                    ->get()
                                    ->mapWithKeys(function ($booking) {
                                        return [$booking->id => $booking->student_name];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        // ================================

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('jenis_setoran')
                            ->options([
                                'ziyadah' => 'Ziyadah (Hafalan Baru)',
                                'murajaah' => 'Murajaah (Mengulang)',
                                'tahsin' => 'Tahsin (Perbaikan Bacaan)',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('surah')
                            ->label('Surah / Materi')
                            ->placeholder('Contoh: An-Naba')
                            ->required(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('ayat_awal')->numeric(),
                                Forms\Components\TextInput::make('ayat_akhir')->numeric(),
                            ]),

                        Forms\Components\Select::make('nilai')
                            ->options([
                                'mumtaz' => 'Mumtaz (Istimewa)',
                                'jayyid_jiddan' => 'Jayyid Jiddan (Sangat Baik)',
                                'jayyid' => 'Jayyid (Baik)',
                                'maqbul' => 'Maqbul (Cukup)',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan & Evaluasi')
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

                Tables\Columns\TextColumn::make('jenis_setoran')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->color(fn(string $state): string => match ($state) {
                        'ziyadah' => 'success',
                        'murajaah' => 'info',
                        'tahsin' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('surah')
                    ->label('Materi')
                    ->formatStateUsing(fn($record) => "{$record->surah} : {$record->ayat_awal}-{$record->ayat_akhir}"),

                Tables\Columns\TextColumn::make('nilai')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'mumtaz' => 'Mumtaz',
                        'jayyid_jiddan' => 'Jayyid Jiddan',
                        'jayyid' => 'Jayyid',
                        'maqbul' => 'Maqbul',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color('success'),
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
            // [MODIFIKASI] HEADER ACTIONS: EXPORT EXCEL RAPI (.XLS)
            // =================================================================
            ->headerActions([
                Tables\Actions\Action::make('export_simple')
                    ->label('Export Excel')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->modalHeading('Export Laporan Tahfidz')
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
                        
                        $fileName = 'Laporan_Tahfidz_' . date('Ymd_His') . '.xls';

                        return response()->streamDownload(function () use ($startDate, $endDate) {
                            $teacherProfile = \App\Models\TeacherProfile::with('user')->where('user_id', Auth::id())->first();
                            $teacherId = $teacherProfile?->id;
                            $namaGuru = $teacherProfile?->user?->name ?? 'Asatidz';

                            $query = \App\Models\Mutabaah::with(['booking'])
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
                            $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHFIDZ SANTRI</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none;">Periode: ' . $periodeText . '</td>';
                            $html .= '</tr>';
                            $html .= '<tr>';
                            $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . htmlspecialchars($namaGuru) . '</td>';
                            $html .= '</tr>';

                            // Header Tabel dengan ketebalan garis .5pt
                            $html .= '<tr>';
                            $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                            $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Asatidz</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                            $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jenis Setoran</th>';
                            $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Hafalan (Surah : Ayat)</th>';
                            $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                            $html .= '<th style="width: 350px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan</th>';
                            $html .= '</tr>';

                            if ($evaluasi->isEmpty()) {
                                $html .= '<tr><td colspan="7" style="text-align: center; border: .5pt solid #000000;">Tidak ada data pada periode ini.</td></tr>';
                            } else {
                                foreach ($evaluasi as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $jenis = ucfirst(htmlspecialchars($row->jenis_setoran ?? '-'));
                                    $hafalan = htmlspecialchars($row->surah . ' Ayat ' . $row->ayat_awal . ' - ' . $row->ayat_akhir);
                                    
                                    $nilaiRaw = $row->nilai ?? '-';
                                    $nilai = match ($nilaiRaw) {
                                        'mumtaz' => 'Mumtaz',
                                        'jayyid_jiddan' => 'Jayyid Jiddan',
                                        'jayyid' => 'Jayyid',
                                        'maqbul' => 'Maqbul',
                                        default => ucfirst($nilaiRaw),
                                    };

                                    $catatan = htmlspecialchars($row->catatan ?? '-');

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . htmlspecialchars($namaGuru) . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $jenis . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $hafalan . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . $nilai . '</td>';
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
            // [MODIFIKASI] BULK ACTIONS: EXPORT EXCEL DATA TERPILIH (.XLS)
            // =================================================================
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('export_terpilih')
                        ->label('Export Excel Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $fileName = 'Laporan_Tahfidz_Terpilih_' . date('Ymd_His') . '.xls';

                            return response()->streamDownload(function () use ($records) {
                                $teacherProfile = \App\Models\TeacherProfile::with('user')->where('user_id', Auth::id())->first();
                                $namaGuru = $teacherProfile?->user?->name ?? 'Asatidz';

                                $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
                                $html .= '<head><meta charset="utf-8"></head><body>';
                                $html .= '<table cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold; border: none; padding-top: 15px;">LAPORAN MUTABAAH TAHFIDZ SANTRI</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none;">Periode: Data Terpilih</td>';
                                $html .= '</tr>';
                                $html .= '<tr>';
                                $html .= '<td colspan="7" style="text-align: center; font-size: 12px; border: none; padding-bottom: 20px;">Pengajar: ' . htmlspecialchars($namaGuru) . '</td>';
                                $html .= '</tr>';

                                $html .= '<tr>';
                                $html .= '<th style="width: 120px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Tanggal Evaluasi</th>';
                                $html .= '<th style="width: 200px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Asatidz</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nama Santri</th>';
                                $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Jenis Setoran</th>';
                                $html .= '<th style="width: 250px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Hafalan (Surah : Ayat)</th>';
                                $html .= '<th style="width: 150px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Nilai</th>';
                                $html .= '<th style="width: 350px; background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; border: .5pt solid #000000;">Catatan</th>';
                                $html .= '</tr>';

                                foreach ($records as $row) {
                                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM Y');
                                    $namaSantri = htmlspecialchars($row->booking->student_name ?? '-');
                                    $jenis = ucfirst(htmlspecialchars($row->jenis_setoran ?? '-'));
                                    $hafalan = htmlspecialchars($row->surah . ' Ayat ' . $row->ayat_awal . ' - ' . $row->ayat_akhir);
                                    
                                    $nilaiRaw = $row->nilai ?? '-';
                                    $nilai = match ($nilaiRaw) {
                                        'mumtaz' => 'Mumtaz',
                                        'jayyid_jiddan' => 'Jayyid Jiddan',
                                        'jayyid' => 'Jayyid',
                                        'maqbul' => 'Maqbul',
                                        default => ucfirst($nilaiRaw),
                                    };

                                    $catatan = htmlspecialchars($row->catatan ?? '-');

                                    $html .= '<tr>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $tanggal . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . htmlspecialchars($namaGuru) . '</td>';
                                    $html .= '<td style="vertical-align: top; border: .5pt solid #000000;">' . $namaSantri . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $jenis . '</td>';
                                    $html .= '<td style="text-align: center; vertical-align: top; border: .5pt solid #000000;">' . $hafalan . '</td>';
                                    $html .= '<td style="text-align: center; font-weight: bold; vertical-align: top; border: .5pt solid #000000;">' . $nilai . '</td>';
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuruMutabaahs::route('/'),
            'create' => Pages\CreateGuruMutabaah::route('/create'),
            'edit' => Pages\EditGuruMutabaah::route('/{record}/edit'),
        ];
    }
}