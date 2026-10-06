<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyMaterialResource\Pages;
use App\Models\StudyMaterial;
use App\Models\TeacherProfile; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudyMaterialResource extends Resource
{
    protected static ?string $model = StudyMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Materi Belajar';
    protected static ?string $pluralModelLabel = 'Repository Materi';
    protected static ?string $navigationGroup = 'Manajemen Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Materi')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Materi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->columnSpanFull(),

                        // PILIHAN GURU (OPSIONAL)
                        Forms\Components\Select::make('teacher_profile_id')
                            ->label('Khusus Murid Guru Tertentu')
                            ->placeholder('Pilih Guru (Biarkan kosong jika Umum)')
                            ->options(TeacherProfile::with('user')->get()->pluck('user.name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live() 
                            ->helperText('Jika dipilih, materi ini HANYA muncul di dashboard murid yang sedang booking guru ini.'),

                        // Pilihan Kelompok Otomatis (Reaktif terhadap Guru)
                        Forms\Components\Select::make('group_name')
                            ->label('Target Kelompok (Grup)')
                            ->options(function (Forms\Get $get) {
                                $teacherId = $get('teacher_profile_id');
                                
                                $query = \App\Models\Booking::where('status', 'active')
                                    ->whereNotNull('group_name');
                                    
                                if ($teacherId) {
                                    $query->where('teacher_profile_id', $teacherId);
                                }

                                return $query->distinct()
                                    ->pluck('group_name', 'group_name')
                                    ->toArray();
                            })
                            ->searchable()
                            ->placeholder('Pilih kelas (Kosongkan jika Lintas Kelas)')
                            ->helperText('Pilih guru terlebih dahulu agar daftar kelas lebih spesifik.'),

                        // PILIHAN TARGET PROGRAM
                        Forms\Components\Select::make('program_type')
                            ->label('Target Program')
                            ->options([
                                'all' => 'Semua Program (Umum)',
                                'online' => 'Khusus Kelas Online',
                                'offline' => 'Khusus Kelas Offline (Home Visit)',
                            ])
                            ->default('all')
                            ->required()
                            ->helperText('Pilih siapa yang bisa melihat materi ini.'),

                        // =========================================================
                        // [MODIFIKASI] JENIS MATERI - TAMBAH AUDIO & SLIDE
                        // =========================================================
                        Forms\Components\Select::make('type')
                            ->label('Jenis Materi')
                            ->options([
                                'video' => 'Video (Link Online)',
                                'document' => 'Dokumen (PDF Upload)',
                                'audio' => 'Audio (MP3/WAV Upload)', 
                                'slide' => 'Slide Presentasi (PPT/PPTX Upload)', // <--- Opsi Slide Baru
                            ])
                            ->required()
                            ->reactive(), 

                        // Input Link Video
                        Forms\Components\TextInput::make('video_url')
                            ->label('Link Video (Youtube/Zoom/Gmeet)')
                            ->url()
                            ->visible(fn(Forms\Get $get) => $get('type') === 'video')
                            ->required(fn(Forms\Get $get) => $get('type') === 'video'),

                        // =========================================================
                        // [MODIFIKASI] UPLOAD MULTIFUNGSI KE CLOUDFLARE R2 (S3)
                        // =========================================================
                        Forms\Components\FileUpload::make('file_path')
                            ->disk('s3') // <--- [BARU] Menyimpan ke Cloudflare R2
                            ->visibility('public') // <--- [BARU] Agar bisa diakses santri
                            ->label(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => 'Upload Audio (MP3/WAV)',
                                'slide' => 'Upload Slide (PPT/PPTX)',
                                default => 'Upload File (PDF)'
                            })
                            // Otomatis menyesuaikan ekstensi file yang diizinkan berdasarkan pilihan 'type'
                            ->acceptedFileTypes(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
                                'slide' => ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
                                default => ['application/pdf']
                            })
                            ->directory(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => 'materials/audio',
                                'slide' => 'materials/slides',
                                default => 'materials/documents'
                            }) // Pisah folder agar rapi
                            ->downloadable()
                            // File upload ini akan muncul jika user memilih document, audio, ATAU slide
                            ->visible(fn(Forms\Get $get) => in_array($get('type'), ['document', 'audio', 'slide']))
                            ->required(fn(Forms\Get $get) => in_array($get('type'), ['document', 'audio', 'slide']))
                            // [BARU] DITAMBAHKAN BATASAN 100MB (102400 KB)
                            ->maxSize(102400)
                            ->helperText('Maksimal ukuran file adalah 100 MB.'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktifkan Materi Ini')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Oleh Guru')
                    ->placeholder('Umum') 
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'gray'), 

                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelompok (Grup)')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->default('Lintas Kelas'), 

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn(StudyMaterial $record) => \Illuminate\Support\Str::limit($record->description, 50)),

                Tables\Columns\TextColumn::make('program_type')
                    ->label('Target')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'all' => 'gray',
                        'online' => 'info',
                        'offline' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'all' => 'Semua',
                        'online' => 'Online',
                        'offline' => 'Offline',
                    }),

                // =========================================================
                // [MODIFIKASI] MENAMPILKAN BADGE AUDIO & SLIDE DI TABEL
                // =========================================================
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'video' => 'danger', 
                        'document' => 'success', 
                        'audio' => 'warning',
                        'slide' => 'info', // <--- Warna Biru untuk Slide
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'video' => 'Video',
                        'document' => 'PDF',
                        'audio' => 'Audio',
                        'slide' => 'Slide PPT', // <--- Format Teks
                    }),

                Tables\Columns\TextColumn::make('completed_by_users_count')
                    ->counts('completedByUsers')
                    ->label('Dipelajari')
                    ->badge()
                    ->color('info')
                    ->suffix(' Santri')
                    ->sortable()
                    ->tooltip('Klik untuk melihat daftar santri') 
                    ->action(
                        Tables\Actions\Action::make('view_students')
                            ->modalHeading(fn ($record) => 'Daftar Santri: ' . $record->title)
                            ->modalDescription('Berikut adalah santri yang telah menyelesaikan materi ini.')
                            ->modalSubmitAction(false) 
                            ->modalCancelActionLabel('Tutup')
                            ->infolist([
                                \Filament\Infolists\Components\TextEntry::make('completedByUsers.name')
                                    ->label('')
                                    ->bulleted() 
                                    ->listWithLineBreaks() 
                                    ->placeholder('Belum ada santri yang menyelesaikan materi ini.'),
                            ])
                    ),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // =========================================================
            // [BARU] FITUR BULK ACTION (Hapus Massal)
            // =========================================================
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
            'index' => Pages\ListStudyMaterials::route('/'),
            'create' => Pages\CreateStudyMaterial::route('/create'),
            'edit' => Pages\EditStudyMaterial::route('/{record}/edit'),
        ];
    }
}