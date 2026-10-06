<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherProfileResource\Pages;
use App\Models\TeacherProfile;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// --- IMPORT COMPONENTS ---
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section as FormSection;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\HtmlString;

class TeacherProfileResource extends Resource
{
    protected static ?string $model = TeacherProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Data Guru';

    protected static ?string $navigationGroup = 'Manajemen Guru';

    // === 1. FORM (INPUT DATA) ===
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FormSection::make('Informasi Akun & Dasar')
                    ->description('Buat akun user baru atau pilih yang sudah ada untuk guru ini.')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Akun User')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->createOptionForm([
                                TextInput::make('name')->label('Nama Lengkap')->required(),
                                TextInput::make('email')->label('Email')->email()->required()->unique('users', 'email'),
                                TextInput::make('password')->label('Password')->password()->revealable()->required(),
                                TextInput::make('phone')->label('No. Telepon / WA')->tel()->maxLength(20),
                                Select::make('gender')->label('Jenis Kelamin')->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
                                TextInput::make('birth_place')->label('Tempat Lahir'),
                                DatePicker::make('birth_date')->label('Tanggal Lahir')->native(false),
                                Textarea::make('address')->label('Alamat')->rows(2),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $user = User::create([
                                    'name' => $data['name'],
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                    'role' => 'teacher',
                                    'phone' => $data['phone'] ?? null,
                                    'gender' => $data['gender'] ?? null,
                                    'birth_place' => $data['birth_place'] ?? null,
                                    'birth_date' => $data['birth_date'] ?? null,
                                    'address' => $data['address'] ?? null,
                                ]);
                                return $user->id;
                            })
                            ->helperText('Klik tombol (+) untuk membuat akun baru secara instan.'),

                        TextInput::make('student_quota')
                            ->label('Kuota Santri')
                            ->numeric()
                            ->default(10)
                            ->required()
                            ->helperText('Jumlah maksimal santri yang bisa mendaftar.'),

                        FileUpload::make('photo')
                            ->label('Foto Profil (Khusus Guru)')
                            ->avatar()
                            ->directory('teacher-photos')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Opsional. Jika kosong, akan menggunakan foto dari akun User.'),

                        TextInput::make('specialization')->label('Keahlian')->placeholder('Contoh: Tahsin Dewasa')->required(),

                        Forms\Components\Select::make('teaching_levels')
                            ->label('Program yang Bisa Diajarkan')
                            ->multiple() 
                            ->options([
                                'iqra'    => 'Program Iqra',
                                'tahsin'  => 'Tahsin (Perbaikan Bacaan)',
                                'tahfidz' => 'Tahfidz (Hafalan)',
                                'sanad'   => 'Program Sanad',
                                'bahasa'  => 'Program Bahasa Arab',
                            ])
                            ->helperText('Pilih satu atau lebih program yang bisa diajarkan oleh Ustadz/Ustadzah ini.')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('method')
                            ->label('Metode Mengajar')
                            ->options(['online' => 'Online', 'offline' => 'Offline'])
                            ->required(),

                        Toggle::make('is_verified')
                            ->label('Status Terverifikasi')
                            ->helperText('Aktifkan jika guru ini sudah disetujui admin.')
                            ->default(false),
                    ])->columns(2),

                FormSection::make('Detail Profil & Pembayaran')
                    ->schema([
                        TextInput::make('bank_account')
                            ->label('Nomor Rekening / E-Wallet')
                            ->placeholder('Contoh: BCA 1234567890 a.n Fulan')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Digunakan untuk keperluan transfer kafalah/gaji mengajar.'),

                        Textarea::make('bio')->label('Bio')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }

    // === 2. TABLE (LIST DATA) ===
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('photo_url')
                    ->label('Foto')
                    ->html()
                    ->state(function (TeacherProfile $record) {
                        $url = $record->photo_url ?? 'https://ui-avatars.com/api/?background=random&name=' . urlencode($record->user->name);
                        return '<img src="' . $url . '" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">';
                    }),

                TextColumn::make('user.name')
                    ->label('Nama Guru')
                    ->sortable()
                    ->searchable()
                    ->description(fn(TeacherProfile $record) => $record->user->phone ?? '-'),

                Tables\Columns\TextColumn::make('teaching_levels')
                    ->label('Program Mengajar')
                    ->badge()
                    ->separator(',') 
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'iqra'    => 'Iqra',
                        'tahsin'  => 'Tahsin',
                        'tahfidz' => 'Tahfidz',
                        'sanad'   => 'Sanad',
                        'bahasa'  => 'Bahasa Arab',
                        null      => '-',
                        default   => ucfirst(str_replace('_', ' ', $state)),
                    })
                    ->color(fn(?string $state): string => match ($state) {
                        'iqra'    => 'success',  
                        'tahsin'  => 'info',     
                        'tahfidz' => 'warning',  
                        'sanad'   => 'danger',   
                        'bahasa'  => 'primary',  
                        default   => 'gray',
                    }),

                TextColumn::make('student_quota')
                    ->label('Kuota')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'online' => 'info',
                        'offline' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('bank_account')
                    ->label('Rekening')
                    ->searchable()
                    ->placeholder('Belum diisi')
                    ->toggleable(isToggledHiddenByDefault: false) 
                    ->copyable() 
                    ->color('gray'),

                TextColumn::make('specialization')
                    ->label('Keahlian')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), 

                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_verified')->label('Filter Status Verifikasi'),
                
                Tables\Filters\TernaryFilter::make('has_bank_account')
                    ->label('Status Rekening')
                    ->placeholder('Semua Guru')
                    ->trueLabel('Sudah Isi Rekening')
                    ->falseLabel('Belum Isi Rekening')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('bank_account')->where('bank_account', '!=', ''),
                        false: fn ($query) => $query->where(function ($q) {
                            return $q->whereNull('bank_account')->orWhere('bank_account', '');
                        }),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // === 3. INFOLIST (HALAMAN DETAIL ADMIN) ===
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Grid::make([
                    'default' => 1, 
                    'md' => 3,      
                    'lg' => 4,      
                ])
                ->schema([

                    InfolistSection::make()
                        ->columnSpan([
                            'md' => 1,
                            'lg' => 1,
                        ])
                        ->schema([
                            TextEntry::make('photo_url')
                                ->hiddenLabel()
                                ->html()
                                ->state(function ($record) {
                                    $url = $record->photo_url;
                                    if (!$url) {
                                        $name = urlencode($record->user->name);
                                        $url = "https://ui-avatars.com/api/?background=random&color=fff&name={$name}";
                                    }
                                    return '<div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                                                <img src="' . $url . '" 
                                                     style="width: 150px; height: 150px; 
                                                            border-radius: 9999px; 
                                                            object-fit: cover; 
                                                            border: 4px solid white; 
                                                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                                            </div>';
                                }),

                            TextEntry::make('user.name')
                                ->label('Nama Lengkap')
                                ->weight(FontWeight::Bold)
                                ->size(TextEntry\TextEntrySize::Large),

                            TextEntry::make('user.phone')
                                ->label('WhatsApp / Telepon')
                                ->icon('heroicon-m-phone')
                                ->color('success')
                                ->copyable()
                                ->url(fn($state) => $state ? "https://wa.me/{$state}" : null, shouldOpenInNewTab: true),

                            IconEntry::make('is_verified')->label('Status Verifikasi')->boolean(),
                        ]),

                    InfolistSection::make('Biodata & Profil Mengajar')
                        ->columnSpan([
                            'md' => 2,
                            'lg' => 3, 
                        ])
                        ->schema([
                            
                            Infolists\Components\Fieldset::make('Status Kontrak & Kesepakatan Kerja')
                                ->schema([
                                    // 1. Teks Isi Kontrak
                                    TextEntry::make('isi_kontrak')
                                        ->hiddenLabel()
                                        ->html()
                                        ->columnSpanFull()
                                        ->state(function () {
                                            return '
                                                <div style="padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; color: #334155; line-height: 1.6; margin-bottom: 8px;">
                                                    <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 1: Masa Kontrak & Komitmen</h4>
                                                    <p style="margin-bottom: 12px;">Pengajar bersedia dan berkomitmen penuh untuk melaksanakan tugas mengajar minimal selama <strong>3 (tiga) bulan berturut-turut</strong> terhitung sejak profil ini disetujui.</p>

                                                    <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 2: Aturan Pengunduran Diri</h4>
                                                    <p style="margin-bottom: 12px;">Pengajar <strong>TIDAK DIPERKENANKAN</strong> mengundurkan diri secara tiba-tiba di tengah-tengah masa rentang waktu mengajar. Apabila terjadi keadaan mendesak (udzur syar\'i), pengajar WAJIB memberitahukan pihak Admin dari jauh hari dan tetap bertugas <strong>sampai ditemukannya guru/pengajar pengganti</strong> agar hak belajar santri tidak terputus.</p>

                                                    <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 3: Persetujuan Sah</h4>
                                                    <p style="margin-bottom: 0;">Dengan mencentang dan mengetikkan nama, pengajar menyatakan dalam keadaan sadar, tanpa paksaan, dan bersedia mematuhi seluruh peraturan yang ditetapkan oleh <strong>Deep Quran Academy</strong>.</p>
                                                </div>
                                            ';
                                        }),

                                    // 2. Status Persetujuan & QR Code Tanda Tangan
                                    Infolists\Components\Grid::make(['default' => 1, 'md' => 2])
                                        ->schema([
                                            TextEntry::make('is_contract_signed')
                                                ->label('Persetujuan Kontrak')
                                                ->badge()
                                                ->formatStateUsing(fn ($state) => $state ? 'Telah Disetujui' : 'Belum Disetujui')
                                                ->color(fn ($state) => $state ? 'success' : 'danger'),
                                                
                                            // =========================================================
                                            // [DIPERBARUI] QR CODE & DATA SCAN
                                            // =========================================================
                                            TextEntry::make('signature_name')
                                                ->label('Tanda Tangan Digital')
                                                ->html()
                                                ->visible(fn ($record) => $record->is_contract_signed)
                                                ->state(function ($record) {
                                                    // 1. Buat Kode Unik secara dinamis
                                                    $uniqueId = 'DQA-' . str_pad($record->id, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5($record->created_at), 0, 6));
                                                    
                                                    // 2. Masukkan ke dalam Data QR (Supaya muncul saat di-scan)
                                                    $dataToEncode = "Dokumen Sah Deep Quran Academy.\nID Verifikasi: " . $uniqueId . "\nDitandatangani oleh: " . $record->signature_name;
                                                    
                                                    // 3. Generate QR Code
                                                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($dataToEncode);
                                                    
                                                    // 4. Tampilan Visual di Layar
                                                    return '
                                                    <div style="display: flex; align-items: center; gap: 12px;">
                                                        <img src="' . $qrUrl . '" style="width: 70px; height: 70px; border: 1px solid #cbd5e1; border-radius: 8px; padding: 4px; background: white;" alt="QR Code">
                                                        <div>
                                                            <strong style="display: block; font-size: 14px; color: #0f172a; margin-bottom: 2px;">' . $record->signature_name . '</strong>
                                                            <span style="font-size: 12px; color: #64748b; margin-bottom: 4px; display: block;">Terverifikasi via Sistem</span>
                                                            <span style="font-size: 11px; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; color: #475569; font-family: monospace;">ID: ' . $uniqueId . '</span>
                                                        </div>
                                                    </div>';
                                                }),
                                        ]),
                                ]),

                            Infolists\Components\Fieldset::make('Informasi Akademik & Pembayaran')
                                ->schema([
                                    Infolists\Components\Grid::make(['default' => 1, 'md' => 3])
                                        ->schema([
                                            TextEntry::make('specialization')->label('Keahlian Utama'),
                                            TextEntry::make('student_quota')->label('Kuota Santri'),
                                            TextEntry::make('method')->label('Metode')->badge(),
                                            
                                            TextEntry::make('bank_account')
                                                ->label('Rekening / E-Wallet')
                                                ->icon('heroicon-o-credit-card')
                                                ->copyable() 
                                                ->placeholder('Belum diisi')
                                                ->columnSpanFull(),
                                        ]),

                                    Infolists\Components\Grid::make(['default' => 1, 'md' => 2])
                                        ->schema([
                                            TextEntry::make('teaching_levels')
                                                ->label('Level Santri yang Diajarkan')
                                                ->badge()
                                                ->separator(',')
                                                ->formatStateUsing(fn(string $state): string => match ($state) {
                                                    'Pemula (Belum Kenal Huruf)' => 'Pemula (Pra-Dasar)',
                                                    'Dasar (Iqra / Terbata)' => 'Dasar (Iqra)',
                                                    'Menengah (Lancar, Butuh Tajwid)' => 'Menengah (Tahsin)',
                                                    'Mahir (Fokus Hafalan / Sanad)' => 'Mahir (Tahfidz/Sanad)',
                                                    default => $state,
                                                })
                                                ->color('success'),
                                                
                                        ]),
                                ]),

                            Infolists\Components\Fieldset::make('Data Pribadi')
                                ->schema([
                                    Infolists\Components\Grid::make(['default' => 1, 'md' => 3])
                                        ->schema([
                                            TextEntry::make('user.birth_place')->label('Tempat Lahir')->placeholder('-'),
                                            TextEntry::make('user.birth_date')->label('Tanggal Lahir')->date('d F Y')->placeholder('-'),
                                            TextEntry::make('user.gender')->label('Jenis Kelamin')
                                                ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : '-')),
                                        ]),
                                        
                                    TextEntry::make('user.address')->label('Alamat Domisili')->placeholder('-')->columnSpanFull(),
                                ]),

                            Infolists\Components\Fieldset::make('Tentang Pengajar')
                                ->schema([
                                    TextEntry::make('bio')
                                        ->hiddenLabel() 
                                        ->markdown()
                                        ->columnSpanFull()
                                        ->placeholder('Belum ada biodata.'),
                                ]),

                        ]),
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
            'index' => Pages\ListTeacherProfiles::route('/'),
            'create' => Pages\CreateTeacherProfile::route('/create'),
            'edit' => Pages\EditTeacherProfile::route('/{record}/edit'),
            'view' => Pages\ViewTeacherProfile::route('/{record}'),
        ];
    }
}