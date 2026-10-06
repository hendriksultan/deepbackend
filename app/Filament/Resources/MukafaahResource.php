<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MukafaahResource\Pages;
use App\Models\TeacherMukafaah;
use App\Models\TeacherProfile;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Forms\Get;
use Filament\Forms\Set;

class MukafaahResource extends Resource
{
    protected static ?string $model = TeacherMukafaah::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Mukafaah Guru';
    protected static ?string $pluralModelLabel = 'Data Mukafaah';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('teacher_profile_id')
                            ->relationship('teacherProfile', 'id')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name)
                            ->label('Nama Pengajar')
                            ->disabled() 
                            ->required(),

                        Forms\Components\TextInput::make('group_name')
                            ->label('Kelas / Rombel')
                            ->disabled(),

                        Forms\Components\TextInput::make('month')->label('Bulan')->disabled(),
                        Forms\Components\TextInput::make('year')->label('Tahun')->disabled(),
                    ])->columns(4),

                // ========================================================
                // KALKULATOR MANUAL (TANPA ASUMSI 150/100K)
                // ========================================================
                Forms\Components\Section::make('Perhitungan Bagi Hasil Infaq')
                    ->description('Masukkan Total Infaq Kelas secara manual, sistem akan menghitung Mukafaah Dasar berdasarkan persentase.')
                    ->schema([
                        Forms\Components\TextInput::make('kalkulator_infaq')
                            ->label('Total Infaq Kelas (Input Manual)')
                            ->prefix('Rp')
                            ->numeric()
                            ->dehydrated(false) // Tidak masuk DB, murni untuk kalkulator
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $persentase = floatval($get('custom_percentage') ?? 0);
                                if ($state > 0 && $persentase > 0) {
                                    $newBase = floatval($state) * ($persentase / 100);
                                    $set('base_amount', $newBase);
                                    self::updateFinalAmount($get, $set);
                                }
                            }),

                        Forms\Components\TextInput::make('custom_percentage')
                            ->label('Persentase Pengajar (%)')
                            ->numeric()
                            ->placeholder('Contoh: 60')
                            ->suffix('%')
                            ->dehydrated(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $totalInfaq = floatval($get('kalkulator_infaq') ?? 0);
                                if ($totalInfaq > 0 && $state > 0) {
                                    $newBase = $totalInfaq * (floatval($state) / 100);
                                    $set('base_amount', $newBase);
                                    self::updateFinalAmount($get, $set);
                                }
                            }),

                        Forms\Components\TextInput::make('base_amount')
                            ->label('Mukafaah Dasar Pengajar')
                            ->prefix('Rp')
                            ->numeric()
                            ->required() 
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateFinalAmount($get, $set)),
                    ])->columns(3),

                // ========================================================
                // KOREKSI MANUAL
                // ========================================================
                Forms\Components\Section::make('Koreksi Manual')
                    ->description('Masukkan nominal jika ada potongan (misal kasbon) atau tambahan bonus untuk kelas ini.')
                    ->schema([
                        Forms\Components\TextInput::make('adjustment_amount')
                            ->label('Koreksi (Angka Minus = Potongan, Positif = Bonus)')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateFinalAmount($get, $set)),

                        Forms\Components\TextInput::make('adjustment_reason')
                            ->label('Alasan Koreksi')
                            ->placeholder('Contoh: Kasbon / Bonus Idul Fitri')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('TOTAL BERSIH & STATUS')
                    ->schema([
                        Forms\Components\TextInput::make('final_amount')
                            ->label('Total Bersih (Siap Transfer)')
                            ->prefix('Rp')
                            ->numeric()
                            ->readOnly() 
                            ->required()
                            ->extraInputAttributes(['style' => 'font-size: 24px; font-weight: bold; color: #16a34a;']),

                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'Belum Dibayar' => 'Belum Dibayar',
                                'Sudah Dibayar' => 'Sudah Dibayar',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Pada Slip (Opsional)')
                            ->placeholder('Tulis pesan apresiasi atau catatan khusus untuk pengajar di slip ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function updateFinalAmount(Get $get, Set $set)
    {
        $base = floatval($get('base_amount') ?? 0);
        $adj = floatval($get('adjustment_amount') ?? 0);

        $final = $base + $adj;
        $set('final_amount', $final);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Guru')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelas / Rombel')
                    ->searchable()
                    ->sortable()
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
                        return ($namaBulan[$bln] ?? $record->month) . ' ' . $record->year;
                    })
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('base_amount')
                    ->label('Mukafaah Dasar')
                    ->money('idr')
                    ->sortable(),

                Tables\Columns\TextColumn::make('final_amount')
                    ->label('Total Transfer')
                    ->money('idr')
                    ->color('success')
                    ->weight('bold'),

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
            ->headerActions([
                Tables\Actions\Action::make('generate_mukafaah')
                    ->label('Generate Mukafaah')
                    ->icon('heroicon-o-sparkles')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Buat Draf Gaji Massal (Per Kelas)')
                    ->modalDescription('Proses ini akan mengenerate draf slip gaji untuk setiap kelas secara massal dengan nilai awal Rp 0. Anda WAJIB menyesuaikan nilai infaq di masing-masing slip melalui menu Edit/Koreksi.')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Periode Bulan')
                            ->options([
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
                            ])
                            ->default(now('Asia/Jakarta')->subMonth()->format('m'))
                            ->required(),
                            
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->default(now('Asia/Jakarta')->year)
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $selectedMonth = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
                        $selectedYear = $data['year'];

                        $teachers = TeacherProfile::all();
                        $generatedCount = 0;

                        foreach ($teachers as $teacher) {
                            $activeBookings = Booking::where('teacher_profile_id', $teacher->id)
                                                ->where('status', 'active')
                                                ->get();

                            if ($activeBookings->isEmpty()) continue;

                            $bookingsByGroup = $activeBookings->groupBy('group_name');

                            foreach ($bookingsByGroup as $groupName => $groupBookings) {
                                $exists = TeacherMukafaah::where('teacher_profile_id', $teacher->id)
                                            ->where('month', $selectedMonth)
                                            ->where('year', $selectedYear)
                                            ->where('group_name', $groupName)
                                            ->first();
                                
                                if ($exists) continue; 

                                // Generate draf kosong (0 rupiah)
                                TeacherMukafaah::create([
                                    'teacher_profile_id' => $teacher->id,
                                    'group_name' => $groupName, 
                                    'month' => $selectedMonth,
                                    'year' => $selectedYear,
                                    'total_attendance' => 0, 
                                    'total_schedule' => 0, 
                                    'base_amount' => 0,
                                    'adjustment_amount' => 0,
                                    'final_amount' => 0, 
                                    'payment_status' => 'Belum Dibayar',
                                ]);
                                $generatedCount++;
                            }
                        }

                        Notification::make()
                            ->title('Pembuatan Draf Selesai')
                            ->body("Berhasil men-generate {$generatedCount} draf slip mukafaah baru. Silakan klik tombol 'Koreksi' pada masing-masing slip untuk memasukkan nilai Infaq.")
                            ->success()
                            ->send();
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Koreksi'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

   public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\MukafaahResource\Pages\ManageMukafaahs::route('/'),
        ];
    }
}