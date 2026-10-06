<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\TeacherProfile;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get; 
use Filament\Forms\Set;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Pendaftaran Masuk';
    protected static ?string $pluralModelLabel = 'Data Pendaftaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pendaftaran')
                    ->description('Detail santri dan pengajar yang dipilih')
                    ->schema([
                        Forms\Components\Select::make('teacher_profile_id')
                            ->label('Pengajar Pilihan')
                            ->options(TeacherProfile::with('user')->get()->pluck('user.name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('program_type')
                            ->label('Program Pilihan')
                            ->options([
                                'iqra' => 'Iqra',
                                'tahsin' => 'Tahsin',
                                'tahfidz' => 'Tahfidz',
                                'sanad' => 'Sanad',
                                'bahasa' => 'Bahasa Arab',
                            ])
                            ->required(),

                        // ========================================================
                        // [BARU] SAKLAR PROGRAM GRATIS
                        // ========================================================
                        Forms\Components\Toggle::make('is_free')
                            ->label('Program Gratis? (Bebas Biaya)')
                            ->helperText('Aktifkan jika santri ini tidak perlu membayar biaya pendaftaran.')
                            ->inline(false)
                            ->default(false)
                            ->live(), // Penting agar perubahan langsung terasa di sistem
                        // ========================================================

                        Forms\Components\Select::make('method')
                            ->label('Metode Belajar')
                            ->options([
                                'online' => 'Online (Zoom/GMeet)',
                                'offline' => 'Offline (Guru Datang ke Rumah)',
                            ])
                            ->required()
                            ->live() 
                            ->native(false),

                        Forms\Components\TextInput::make('group_name')
                            ->label('Nama Kelompok / Halqoh')
                            ->placeholder('Contoh: Tahsin A, Tahfidz Pagi')
                            ->helperText('Wajib diisi agar muncul di grouping dashboard guru.')
                            ->required(),

                        Forms\Components\Textarea::make('student_address')
                            ->label('Alamat Lengkap (Home Visit)')
                            ->placeholder('Masukkan alamat lengkap santri...')
                            ->rows(3)
                            ->visible(fn(Get $get) => $get('method') === 'offline') 
                            ->columnSpanFull()
                            ->required(fn(Get $get) => $get('method') === 'offline'),

                        Forms\Components\TextInput::make('maps_link')
                            ->label('Link Google Maps')
                            ->placeholder('https://maps.google.com/...')
                            ->url()
                            ->visible(fn(Get $get) => $get('method') === 'offline') 
                            ->columnSpanFull(),
                            
                            // ========================================================
                        // [TAMBAHKAN KODE INI DI SINI]
                        // ========================================================
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude (Garis Lintang)')
                            ->placeholder('Contoh: -6.9200123')
                            ->numeric()
                            ->visible(fn(Get $get) => $get('method') === 'offline')
                            ->helperText('Diisi untuk menampilkan lokasi kelompok di peta.'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude (Garis Bujur)')
                            ->placeholder('Contoh: 106.9200456')
                            ->numeric()
                            ->visible(fn(Get $get) => $get('method') === 'offline')
                            ->helperText('Diisi untuk menampilkan lokasi kelompok di peta.'),
                        // ========================================================

                    ])->columns(2),

                Forms\Components\Section::make('Data Diri Santri')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pilih Akun Santri Terdaftar')
                            ->options(User::where('role', 'student')->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($state) {
                                    $user = User::find($state);
                                    if ($user) {
                                        $set('student_name', $user->name);
                                        $set('email', $user->email);
                                        $set('whatsapp', $user->phone ?? $user->whatsapp ?? ''); 
                                    }
                                }
                            })
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('student_name')
                            ->label('Nama Santri')
                            ->required(), 

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('whatsapp')
                            ->label('No. WhatsApp')
                            ->required()
                            ->suffixAction(
                                \Filament\Forms\Components\Actions\Action::make('wa_link')
                                    ->icon('heroicon-m-chat-bubble-left-right')
                                    ->color('success')
                                    ->url(fn(\Filament\Forms\Get $get) => "https://wa.me/" . $get('whatsapp'), true)
                                    ->openUrlInNewTab()
                            ),
                    ])->columns(3),

                Forms\Components\Section::make('Verifikasi & Status')
                    ->description('Cek bukti bayar dan update status pendaftaran di sini')
                    ->schema([
                        // Bukti transfer otomatis tersembunyi jika Admin mencentang "Program Gratis"
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Bukti Transfer')
                            ->image()
                            ->disk('public')
                            ->directory('payments')
                            ->visibility('public')
                            ->downloadable()
                            ->openable()
                            ->hidden(fn(Get $get) => $get('is_free')) // <--- Sembunyikan jika gratis
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status')
                            ->label('Status Pendaftaran')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'verifying' => 'Sedang Diverifikasi',
                                'active' => 'Aktif / Diterima',
                                'rejected' => 'Ditolak',
                            ])
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Tanggal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Pengajar')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student_name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn(Booking $record) => $record->group_name ? 'Kelompok: ' . $record->group_name : '-'),

                // Menampilkan badge "GRATIS" di tabel agar Admin mudah membedakan
                Tables\Columns\IconColumn::make('is_free')
                    ->label('Gratis')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->colors([
                        'info' => 'online',
                        'warning' => 'offline',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('program_type')
                    ->label('Program')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'tahsin' => 'info',
                        'tahfidz' => 'success',
                        'sanad' => 'warning',
                        'talaqqi' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => ucfirst($state ?? '-')),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verifying' => 'info',
                        'active' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'verifying' => 'Verifikasi',
                        'active' => 'Aktif',
                        'rejected' => 'Ditolak',
                        default => ucfirst($state ?? '-'),
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('hubungi')
                    ->label('Chat WA')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn(Booking $record) => "https://wa.me/{$record->whatsapp}", true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}