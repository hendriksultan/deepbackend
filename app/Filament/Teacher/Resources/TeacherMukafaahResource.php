<?php

namespace App\Filament\Teacher\Resources;

use App\Models\TeacherMukafaah;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;

class TeacherMukafaahResource extends Resource
{
    protected static ?string $model = TeacherMukafaah::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationLabel = 'Rincian Mukafaah';
    protected static ?string $pluralModelLabel = 'Mukafaah Saya';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $teacherId = auth()->user()->teacherProfile->id ?? 0;
        return $query->where('teacher_profile_id', $teacherId);
    }

    public static function canCreate(): bool { return false; }
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool { return false; }
    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool { return false; }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('SLIP MUKAFAAH PENGAJAR')
                    ->description('Dokumen resmi rincian honorarium Deep Quran Academy')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        // Baris 1: Info Guru, Kelas, & Periode
                        Grid::make(3)->schema([
                            TextEntry::make('teacherProfile.user.name')
                                ->label('Nama Ustadz/Ustadzah')
                                ->weight('bold')
                                ->size(TextEntry\TextEntrySize::Large),
                            
                            TextEntry::make('group_name')
                                ->label('Kelas / Halaqoh')
                                ->weight('bold')
                                ->color('primary')
                                ->size(TextEntry\TextEntrySize::Large)
                                ->default('-'),
                            
                            TextEntry::make('periode')
                                ->label('Periode Pembayaran')
                                ->state(function ($record) {
                                    $namaBulan = [
                                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                    ];
                                    $bln = str_pad($record->month, 2, '0', STR_PAD_LEFT);
                                    $bulanHuruf = $namaBulan[$bln] ?? $record->month;
                                    
                                    return $bulanHuruf . ' ' . $record->year;
                                })
                                ->badge()
                                ->color('info'),
                        ]),

                        // =======================================================
                        // Baris 2: Mukafaah Dasar, Peserta, Status
                        // =======================================================
                        Grid::make(3)->schema([
                            TextEntry::make('base_amount')
                                ->label('Mukafaah Dasar Pengajar') 
                                ->money('idr')
                                ->weight('bold')
                                ->size(TextEntry\TextEntrySize::Large),

                            TextEntry::make('jumlah_peserta')
                                ->label('Santri Aktif')
                                ->state(function ($record) {
                                    $jumlah = Booking::where('teacher_profile_id', $record->teacher_profile_id)
                                        ->when($record->group_name, fn($q) => $q->where('group_name', $record->group_name))
                                        ->where('status', 'active')
                                        ->count();
                                        
                                    return $jumlah . ' Orang';
                                })
                                ->size(TextEntry\TextEntrySize::Large)
                                ->weight('bold')
                                ->color('primary')
                                ->icon('heroicon-m-users'),
                                
                            TextEntry::make('payment_status')
                                ->label('Status Pembayaran')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    'Belum Dibayar' => 'warning',
                                    'Sudah Dibayar' => 'success',
                                    default => 'gray',
                                }),
                        ]),

                        // Baris 3: Rincian Potongan / Bonus
                        Section::make('Penyesuaian (Koreksi/Bonus/Potongan)')->schema([
                            Grid::make(2)->schema([
                                TextEntry::make('adjustment_amount')
                                    ->label('Nominal Penyesuaian')
                                    ->money('idr')
                                    ->color(fn ($record) => $record->adjustment_amount < 0 ? 'danger' : 'success')
                                    ->weight('bold'),
                                
                                TextEntry::make('adjustment_reason')
                                    ->label('Keterangan Penyesuaian')
                                    ->state(fn ($record) => $record->adjustment_reason ?? 'Tidak ada potongan / bonus.')
                                    ->color('gray'),
                            ]),
                        ])->collapsed(false), 

                        // Baris 3.5: Kolom Catatan Pada Slip
                        Section::make('Catatan Administratif')
                            ->schema([
                                TextEntry::make('notes')
                                    ->hiddenLabel()
                                    ->color('gray')
                                    ->extraAttributes(['style' => 'font-style: italic;']), 
                            ])
                            ->visible(fn ($record) => filled($record->notes)),

                        // =======================================================
                        // Baris 4: Total Penerimaan Besar
                        // =======================================================
                        Section::make('Total Penerimaan Bersih')->schema([
                            TextEntry::make('final_amount')
                                ->hiddenLabel()
                                ->html()
                                ->state(fn ($record) => new HtmlString(
                                    '<div style="font-size: 2rem; font-weight: 900; color: #16a34a; letter-spacing: -2px; line-height: 1; padding: 10px 0;">' 
                                    . 'Rp ' . number_format($record->final_amount, 0, ',', '.') . 
                                    '</div>'
                                )),
                        ]),

                        // =======================================================
                        // Baris 5: TANDA TANGAN ELEKTRONIK (QR CODE)
                        // =======================================================
                        Section::make()->schema([
                            TextEntry::make('pengesahan')
                                ->hiddenLabel()
                                ->columnSpanFull() 
                                ->alignRight()     
                                ->html()
                                ->state(function ($record) {
                                    $uniqueId = 'DQA-MKF-' . $record->year . $record->month . '-' . str_pad($record->id, 4, '0', STR_PAD_LEFT);
                                    
                                    $qrData = "Validasi Slip Mukafaah\nDeep Quran Academy\nID: {$uniqueId}\nStatus: {$record->payment_status}";
                                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($qrData);

                                    return new HtmlString('
                                    <div style="width: 100%; text-align: right; padding-top: 15px;">
                                        <div style="display: inline-block; text-align: center; min-width: 250px;">
                                            <div style="border-top: 2px dashed #e5e7eb; padding-top: 15px; margin-bottom: 5px;"></div>
                                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #6b7280; font-style: italic;">Disahkan secara elektronik oleh,</p>
                                            <img src="' . $qrUrl . '" alt="QR Code" style="width: 90px; height: 90px; border: 1px solid #d1d5db; padding: 4px; border-radius: 8px; background: white; margin: 0 auto;">
                                            <h4 style="margin: 10px 0 2px 0; font-size: 15px; font-weight: 800; color: #111827;">Manajemen Keuangan</h4>
                                            <h5 style="margin: 0 0 4px 0; font-size: 14px; font-weight: bold; color: #15803d;">Deep Quran Academy</h5>
                                            <p style="margin: 0; font-size: 11px; color: #9ca3af; font-family: monospace;">Ref: ' . $uniqueId . '</p>
                                        </div>
                                    </div>
                                    ');
                                }),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelas / Rombel')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->default('-'),

                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode')
                    ->state(function ($record) {
                        $namaBulan = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                        $bln = str_pad($record->month, 2, '0', STR_PAD_LEFT);
                        $bulanHuruf = $namaBulan[$bln] ?? $record->month;
                        
                        return $bulanHuruf . ' ' . $record->year;
                    })
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('final_amount')
                    ->label('Total Diterima')
                    ->money('idr')
                    ->size('lg')
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Belum Dibayar' => 'warning',
                        'Sudah Dibayar' => 'success',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Slip')
                    ->icon('heroicon-m-document-magnifying-glass')
                    ->color('primary')
                    ->modalHeading('Slip Mukafaah Resmi')
                    ->modalSubmitAction(false) 
                    ->modalCancelActionLabel('Tutup Slip'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Teacher\Resources\TeacherMukafaahResource\Pages\ManageTeacherMukafaahs::route('/'),
        ];
    }
}