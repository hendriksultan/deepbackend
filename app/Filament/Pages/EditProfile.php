<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DatePicker; 
use Filament\Forms\Components\Select;     
use Filament\Forms\Components\Textarea;   
use Filament\Forms\Form;
use Filament\Forms; 
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class EditProfile extends BaseEditProfile
{
  public function getMaxContentWidth(): ?string
  {
    return '5xl';
  }

  public function getTitle(): string
  {
    return '';
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Group::make()
          ->schema([
            Placeholder::make('custom_title')
              ->hiddenLabel()
              ->content(new HtmlString('
                                <style>
                                    form {
                                        padding-bottom: 10px !important;
                                    }
                                </style>
                                <h1 class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white mb-2">
                                    Profil Saya
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Kelola informasi profil, biodata lengkap, dan keamanan akun Anda.
                                </p>
                            ')),

            Section::make('Informasi Akun')
              ->aside()
              ->description('Foto profil dan kontak yang bisa dihubungi.')
              ->schema([
                FileUpload::make('profile_photo_path')
                  ->label('Foto Profil')
                  ->avatar()
                  ->image()
                  ->imageEditor()
                  ->directory('profile-photos')
                  ->columnSpanFull()
                  ->alignCenter(),

                TextInput::make('name')
                  ->label('Nama Lengkap')
                  ->required()
                  ->maxLength(255),

                TextInput::make('email')
                  ->label('Email')
                  ->email()
                  ->required()
                  ->maxLength(255)
                  ->unique(ignoreRecord: true),

                TextInput::make('phone')
                  ->label('No. Telepon / WA')
                  ->tel()
                  ->maxLength(20),
              ]),

            Section::make('Biodata Lengkap')
              ->aside()
              ->description('Data kelahiran dan alamat domisili.')
              ->schema([
                TextInput::make('birth_place')
                  ->label('Tempat Lahir')
                  ->maxLength(100),

                DatePicker::make('birth_date')
                  ->label('Tanggal Lahir')
                  ->displayFormat('d F Y')
                  ->native(false),

                Select::make('gender')
                  ->label('Jenis Kelamin')
                  ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                  ]),

                Textarea::make('address')
                  ->label('Alamat Lengkap / Detail Jalan')
                  ->rows(2)
                  ->columnSpanFull(),

                Select::make('province')
                    ->label('Provinsi')
                    ->searchable()
                    ->live()
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

                Select::make('city')
                    ->label('Kota / Kabupaten')
                    ->searchable()
                    ->live()
                    ->options(function (Forms\Get $get) {
                        $provinceName = $get('province');
                        if (!$provinceName) return [];

                        $provinces = Cache::remember('api_provinces_raw_v2', 86400, function () {
                            return Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
                        });
                        $provinceId = collect($provinces)->firstWhere('name', $provinceName)['id'] ?? null;
                        if (!$provinceId) return [];

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

                Select::make('district')
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

                Select::make('village')
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

              ])->columns(2),

            Section::make('Profil & Pembayaran') 
              ->aside()
              ->description('Isi biodata pengalaman dan nomor rekening pencairan kafalah Anda.')
              ->relationship('teacherProfile') 
              ->schema([
                TextInput::make('bank_account')
                  ->label('Nomor Rekening / E-Wallet')
                  ->placeholder('Contoh: BCA 1234567890 a.n Fulan')
                  ->maxLength(255)
                  ->columnSpanFull()
                  ->helperText('Pastikan nomor rekening dan atas nama sudah benar untuk keperluan transfer kafalah bulanan.'),

                Textarea::make('bio')
                  ->label('Bio / Pengalaman')
                  ->placeholder('Ceritakan pengalaman belajar dan mengajar Anda di sini...')
                  ->rows(6)
                  ->columnSpanFull(),
              ]),

            Section::make('Lembar Kesepakatan Kerja')
              ->aside()
              ->description('Kontrak mengajar yang wajib dibaca dan disetujui sebelum Anda dapat mengajar.')
              ->relationship('teacherProfile')
              ->schema([
                Placeholder::make('kontrak')
                  ->hiddenLabel()
                  ->content(new HtmlString('
                        <div style="padding: 16px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; font-size: 0.875rem; color: #92400e; line-height: 1.6;">
                            <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 1: Masa Kontrak & Komitmen</h4>
                            <p style="margin-bottom: 12px;">Pengajar bersedia dan berkomitmen penuh untuk melaksanakan tugas mengajar minimal selama <strong>3 (tiga) bulan berturut-turut</strong> terhitung sejak profil ini disetujui.</p>

                            <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 2: Aturan Pengunduran Diri</h4>
                            <p style="margin-bottom: 12px;">Pengajar <strong>TIDAK DIPERKENANKAN</strong> mengundurkan diri secara tiba-tiba di tengah-tengah masa rentang waktu mengajar. Apabila terjadi keadaan mendesak (udzur syar\'i), pengajar WAJIB memberitahukan pihak Admin dari jauh hari dan tetap bertugas <strong>sampai ditemukannya guru/pengajar pengganti</strong> agar hak belajar santri tidak terputus.</p>

                            <h4 style="font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">Pasal 3: Persetujuan Sah</h4>
                            <p style="margin-bottom: 0;">Dengan mencentang dan mengetikkan nama di bawah ini, saya menyatakan dalam keadaan sadar, tanpa paksaan, dan bersedia mematuhi seluruh peraturan yang ditetapkan oleh <strong>Deep Quran Academy</strong>.</p>
                        </div>
                  ')),

                // MUNCUL JIKA GURU BELUM TANDA TANGAN
                Forms\Components\Checkbox::make('is_contract_signed')
                  ->label('Saya telah membaca, memahami, dan menyetujui poin-poin kesepakatan di atas.')
                  ->required()
                  ->accepted()
                  ->visible(fn () => !auth()->user()?->teacherProfile?->is_contract_signed),

                Forms\Components\TextInput::make('signature_name')
                  ->label('Tanda Tangan Digital (Ketik Nama Lengkap Anda)')
                  ->required()
                  ->placeholder('Ketik nama Anda di sini...')
                  ->visible(fn () => !auth()->user()?->teacherProfile?->is_contract_signed)
                  ->helperText('Mengetikkan nama di kolom ini memiliki kekuatan yang setara dengan tanda tangan basah secara hukum digital.'),

                // =========================================================
                // [DIPERBARUI] QR CODE TANDA TANGAN + KODE UNIK
                // =========================================================
                Placeholder::make('ttd_sah')
                  ->hiddenLabel()
                  ->visible(fn () => auth()->user()?->teacherProfile?->is_contract_signed)
                  ->content(function () {
                      $profile = auth()->user()?->teacherProfile;
                      $name = $profile?->signature_name ?? 'Pengajar';
                      
                      // 1. Buat Kode Unik secara dinamis
                      $uniqueId = 'DQA-' . str_pad($profile?->id ?? 0, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5($profile?->created_at ?? time()), 0, 6));
                      
                      // 2. Masukkan ke dalam Data QR
                      $dataToEncode = "Dokumen Sah Deep Quran Academy.\nID Verifikasi: " . $uniqueId . "\nDitandatangani oleh: " . $name;
                      
                      // 3. Generate QR Code menggunakan API
                      $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($dataToEncode);

                      return new HtmlString('
                          <div style="padding: 16px; background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 8px; display: flex; align-items: center; gap: 16px;">
                              <img src="' . $qrUrl . '" style="width: 80px; height: 80px; border: 1px solid #cbd5e1; border-radius: 8px; padding: 4px; background: white;" alt="QR Code">
                              <div>
                                  <strong style="display: block; font-size: 15px; color: #166534; margin-bottom: 4px;">Telah Disetujui & Ditandatangani Secara Digital</strong>
                                  <span style="font-size: 14px; color: #15803d; margin-bottom: 2px; display: block;">Oleh: <strong>'.$name.'</strong></span>
                                  <span style="font-size: 12px; color: #16a34a; margin-bottom: 4px; display: block;">Terverifikasi via Sistem Deep Quran Academy</span>
                                  <span style="font-size: 11px; background: #bbf7d0; padding: 2px 6px; border-radius: 4px; color: #166534; font-family: monospace;">ID: ' . $uniqueId . '</span>
                              </div>
                          </div>
                      ');
                  }),
              ]),

            Section::make('Keamanan Akun')
              ->aside()
              ->description('Kosongkan jika tidak ingin mengubah password.')
              ->schema([
                TextInput::make('password')
                  ->label('Password Baru')
                  ->password()
                  ->revealable()
                  ->confirmed()
                  ->dehydrated(fn($state) => filled($state))
                  ->required(fn($livewire) => $livewire instanceof CreateRecord),

                TextInput::make('password_confirmation')
                  ->label('Ulangi Password Baru')
                  ->password()
                  ->revealable()
                  ->dehydrated(false),
              ]),
          ])
          ->extraAttributes(['class' => 'pt-10 space-y-8']),
      ]);
  }

  public function getLayout(): string
  {
    return 'filament-panels::components.layout.index';
  }
}