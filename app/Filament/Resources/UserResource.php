<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

// Import Facades untuk Email, Notifikasi, HTTP Request (API), dan Cache
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

// Import tambahan untuk fitur Action, BulkAction, dll
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';

    /* =========================================================
     | FORM
     | ========================================================= */
    public static function form(Form $form): Form
    {
        return $form->schema([

            /* ================= FOTO PROFIL ================= */
            Forms\Components\Section::make('Foto Profil')
                ->schema([
                    Forms\Components\FileUpload::make('profile_photo_path')
                        ->label('Foto')
                        ->image()
                        ->avatar() 
                        ->imageEditor() 
                        ->directory('profile-photos')
                        ->columnSpanFull()
                        ->alignCenter(),
                ])
                ->columnSpan(1),

            /* ================= DATA UTAMA ================= */
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Informasi Akun')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('phone')
                                ->label('No. Telepon / WA')
                                ->tel()
                                ->maxLength(20),

                            Forms\Components\TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $context): bool => $context === 'create')
                                ->helperText(fn(string $context): string => $context === 'edit' ? 'Biarkan kosong jika tidak ingin mengubah.' : ''),

                            Forms\Components\Select::make('role')
    ->label('Role')
    ->options([
        'admin'   => 'Admin',
        'teacher' => 'Guru',
        'student' => 'Santri',
    ])
    ->required()
    ->reactive()
    ->disabled(function ($record) {
        if (!$record) return false; 
        // Admin tidak bisa ubah role admin lain
        return $record->role === 'admin' && $record->id !== auth()->id();
    }),

                            Forms\Components\Select::make('student_level')
                                ->label('Program Pilihan (Santri)')
                                ->options([
                                    'iqra'    => 'Program Iqra (Dasar)',
                                    'tahsin'  => 'Program Tahsin (Perbaikan Tajwid)',
                                    'tahfidz' => 'Program Tahfidz (Hafalan)',
                                    'sanad'   => 'Program Sanad',
                                    'bahasa'  => 'Bahasa Arab',
                                ])
                                ->visible(fn(Forms\Get $get) => in_array($get('role'), ['student', 'santri'])),

                            Forms\Components\Toggle::make('is_verified')
                                ->label('Status Verifikasi')
                                ->helperText('Aktifkan agar user bisa login')
                                ->default(false)
                                ->visible(fn(Forms\Get $get) => in_array($get('role'), ['student', 'teacher']))
                                ->disabled(fn() => auth()->user()?->role !== 'admin'),
                        ])->columns(2),

                    /* ================= BIODATA LENGKAP & ALAMAT ================= */
                    Forms\Components\Section::make('Biodata Lengkap & Alamat')
                        ->description('Data kelahiran dan alamat domisili.')
                        ->schema([
                            Forms\Components\TextInput::make('birth_place')
                                ->label('Tempat Lahir')
                                ->maxLength(100),

                            Forms\Components\DatePicker::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->displayFormat('d F Y')
                                ->native(false),

                            Forms\Components\Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ]),

                            Forms\Components\Textarea::make('address')
                                ->label('Alamat Lengkap / Detail Jalan')
                                ->rows(2)
                                ->columnSpanFull(),

                            // =========================================================
                            // [DIPERBARUI] Dropdown Wilayah Otomatis dari API Emsifa (Title Case)
                            // =========================================================
                            
                            Forms\Components\Select::make('province')
                                ->label('Provinsi')
                                ->searchable()
                                ->live() // Trigger perubahan ke dropdown bawahnya
                                ->options(function () {
                                    return Cache::remember('api_provinces_v2', 86400, function () {
                                        $res = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                                        return $res->successful() ? collect($res->json())->mapWithKeys(function ($item) {
                                            return [$item['name'] => ucwords(strtolower($item['name']))];
                                        })->toArray() : [];
                                    });
                                })
                                ->afterStateUpdated(function (Forms\Set $set) {
                                    $set('city', null);
                                    $set('district', null);
                                    $set('village', null);
                                }),

                            Forms\Components\Select::make('city')
                                ->label('Kota / Kabupaten')
                                ->searchable()
                                ->live()
                                ->options(function (Forms\Get $get) {
                                    $provinceName = $get('province');
                                    if (!$provinceName) return [];

                                    // Cari ID Provinsi berdasarkan Nama yang dipilih
                                    $provinces = Cache::remember('api_provinces_raw_v2', 86400, function () {
                                        return Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
                                    });
                                    $provinceId = collect($provinces)->firstWhere('name', $provinceName)['id'] ?? null;
                                    if (!$provinceId) return [];

                                    // Ambil data Kota berdasarkan ID Provinsi
                                    return Cache::remember("api_cities_v2_{$provinceId}", 86400, function () use ($provinceId) {
                                        $res = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
                                        return $res->successful() ? collect($res->json())->mapWithKeys(function ($item) {
                                            return [$item['name'] => ucwords(strtolower($item['name']))];
                                        })->toArray() : [];
                                    });
                                })
                                ->afterStateUpdated(function (Forms\Set $set) {
                                    $set('district', null);
                                    $set('village', null);
                                }),

                            Forms\Components\Select::make('district')
                                ->label('Kecamatan')
                                ->searchable()
                                ->live()
                                ->options(function (Forms\Get $get) {
                                    $provinceName = $get('province');
                                    $cityName = $get('city');
                                    if (!$provinceName || !$cityName) return [];

                                    $provinces = Cache::get('api_provinces_raw_v2');
                                    $provinceId = collect($provinces)->firstWhere('name', $provinceName)['id'] ?? null;
                                    if (!$provinceId) return [];

                                    $cities = Cache::remember("api_cities_raw_v2_{$provinceId}", 86400, function () use ($provinceId) {
                                        return Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json")->json();
                                    });
                                    $cityId = collect($cities)->firstWhere('name', $cityName)['id'] ?? null;
                                    if (!$cityId) return [];

                                    return Cache::remember("api_districts_v2_{$cityId}", 86400, function () use ($cityId) {
                                        $res = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json");
                                        return $res->successful() ? collect($res->json())->mapWithKeys(function ($item) {
                                            return [$item['name'] => ucwords(strtolower($item['name']))];
                                        })->toArray() : [];
                                    });
                                })
                                ->afterStateUpdated(function (Forms\Set $set) {
                                    $set('village', null);
                                }),

                            Forms\Components\Select::make('village')
                                ->label('Desa / Kelurahan')
                                ->searchable()
                                ->options(function (Forms\Get $get) {
                                    $provinceName = $get('province');
                                    $cityName = $get('city');
                                    $districtName = $get('district');
                                    if (!$provinceName || !$cityName || !$districtName) return [];

                                    $provinces = Cache::get('api_provinces_raw_v2');
                                    $provinceId = collect($provinces)->firstWhere('name', $provinceName)['id'] ?? null;
                                    if (!$provinceId) return [];

                                    $cities = Cache::get("api_cities_raw_v2_{$provinceId}");
                                    $cityId = collect($cities)->firstWhere('name', $cityName)['id'] ?? null;
                                    if (!$cityId) return [];

                                    $districts = Cache::remember("api_districts_raw_v2_{$cityId}", 86400, function () use ($cityId) {
                                        return Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json")->json();
                                    });
                                    $districtId = collect($districts)->firstWhere('name', $districtName)['id'] ?? null;
                                    if (!$districtId) return [];

                                    return Cache::remember("api_villages_v2_{$districtId}", 86400, function () use ($districtId) {
                                        $res = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
                                        return $res->successful() ? collect($res->json())->mapWithKeys(function ($item) {
                                            return [$item['name'] => ucwords(strtolower($item['name']))];
                                        })->toArray() : [];
                                    });
                                }),
                            // =========================================================

                        ])->columns(2),
                ])
                ->columnSpan(2),
        ])->columns(3);
    }

    /* =========================================================
     | TABLE
     | ========================================================= */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_path')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn(User $record) => $record->gender === 'L' ? 'Laki-laki' : ($record->gender === 'P' ? 'Perempuan' : '-')),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('Domisili')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin'   => 'danger',
                        'teacher' => 'success',
                        'student' => 'info',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'teacher' => 'Guru',
                        'student' => 'Santri',
                        default   => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('student_level')
                    ->label('Program (Santri)')
                    ->badge()
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
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\ToggleColumn::make('is_verified')
                    ->label('Verif')
                    ->disabled(function (User $record) {
                        return !in_array($record->role, ['student', 'teacher']) || auth()->user()?->role !== 'admin';
                    })
                    ->afterStateUpdated(function (User $record, $state) {
                        if ($state === true) {
                            $loginUrl = url('/login');
                            $htmlMessage = "
                                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px;'>
                                    <h2 style='color: #15803d; text-align: center;'>Akun Terverifikasi! 🎉</h2>
                                    <p>Assalamu'alaikum, <strong>{$record->name}</strong>,</p>
                                    <p>Alhamdulillah, pendaftaran akun Anda di <strong>Deep Quran Academy</strong> telah diverifikasi oleh tim Admin kami.</p>
                                    <p>Sekarang Anda sudah bisa login dan mengakses layanan kami menggunakan email dan password yang telah Anda buat saat pendaftaran.</p>
                                    
                                    <div style='text-align: center; margin: 30px 0;'>
                                        <a href='{$loginUrl}' style='background-color: #15803d; color: white; padding: 12px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Login Sekarang</a>
                                    </div>
                                    
                                    <p style='margin-top: 30px; font-size: 14px; color: #6b7280;'>Jazakumullah Khairan,<br><strong>Admin Deep Quran Academy</strong></p>
                                </div>
                            ";

                            Mail::html($htmlMessage, function ($message) use ($record) {
                                $message->to($record->email)
                                    ->subject('Akun Telah Diverifikasi - Deep Quran Academy');
                            });

                            Notification::make()
                                ->title('User Diverifikasi')
                                ->body("Email pemberitahuan berhasil dikirim ke {$record->email}")
                                ->success()
                                ->send();
                        }
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Daftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin'   => 'Admin',
                        'teacher' => 'Guru',
                        'student' => 'Santri',
                    ]),
                Tables\Filters\Filter::make('pending_verification')
                    ->label('Menunggu Verifikasi')
                    ->query(fn($query) => $query->whereIn('role', ['student', 'teacher'])->where('is_verified', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // =========================================================
                // Tombol Kirim Pesan Personal (Per User)
                // =========================================================
                Action::make('kirim_notifikasi')
                    ->label('Beri Pesan')
                    ->icon('heroicon-o-bell-alert')
                    ->color('info')
                    ->form([
                        TextInput::make('title')
                            ->label('Judul Pesan')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('body')
                            ->label('Isi Pesan')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        Notification::make()
                            ->title($data['title'])
                            ->body($data['body'])
                            ->icon('heroicon-o-megaphone')
                            ->success()
                            ->sendToDatabase($record);

                        Notification::make()
                            ->title('Notifikasi terkirim ke ' . $record->name)
                            ->success()
                            ->send();
                    }),
                // =========================================================

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // =========================================================
                    // Tombol Kirim Pesan Massal (Bulk Action)
                    // =========================================================
                    BulkAction::make('kirim_notifikasi_massal')
                        ->label('Kirim Notifikasi Massal')
                        ->icon('heroicon-o-bell-alert')
                        ->color('info')
                        ->form([
                            TextInput::make('title')
                                ->label('Judul Pengumuman')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('body')
                                ->label('Isi Pengumuman')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            foreach ($records as $record) {
                                Notification::make()
                                    ->title($data['title'])
                                    ->body($data['body'])
                                    ->icon('heroicon-o-megaphone')
                                    ->success()
                                    ->sendToDatabase($record);
                            }

                            Notification::make()
                                ->title('Berhasil mengirim notifikasi ke ' . $records->count() . ' user')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(), 
                    // =========================================================

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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}