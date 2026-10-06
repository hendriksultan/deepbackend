<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudyMaterialResource\Pages;
use App\Models\StudyMaterial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudyMaterialResource extends Resource
{
    protected static ?string $model = StudyMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Materi Belajar';
    protected static ?string $modelLabel = 'Materi Belajar';
    protected static ?string $pluralModelLabel = 'Repository Materi';
    protected static ?string $navigationGroup = 'Manajemen Kelas';

    public static function getEloquentQuery(): Builder
    {
        $teacherProfileId = Auth::user()->teacherProfile->id ?? null;
        
        return parent::getEloquentQuery()
            ->where('teacher_profile_id', $teacherProfileId);
    }

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

                        Forms\Components\Select::make('group_name')
                            ->label('Target Kelompok (Grup)')
                            ->options(function () {
                                $teacherId = Auth::user()->teacherProfile->id ?? null;
                                if (!$teacherId) return [];

                                return \App\Models\Booking::where('teacher_profile_id', $teacherId)
                                    ->where('status', 'active')
                                    ->whereNotNull('group_name')
                                    ->distinct()
                                    ->pluck('group_name', 'group_name')
                                    ->toArray();
                            })
                            ->searchable()
                            ->placeholder('Pilih kelas (Kosongkan jika untuk semua santri Anda)')
                            ->helperText('Jika diisi, hanya santri di kelas ini yang bisa melihat materi.'),

                        Forms\Components\Select::make('program_type')
                            ->label('Target Metode')
                            ->options([
                                'all' => 'Semua Metode (Umum)',
                                'online' => 'Khusus Kelas Online',
                                'offline' => 'Khusus Kelas Offline (Home Visit)',
                            ])
                            ->default('all')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('teacher_profile_id')
                            ->default(fn () => Auth::user()->teacherProfile->id ?? null),

                        // =========================================================
                        // [MODIFIKASI] JENIS MATERI - DITAMBAHKAN SLIDE PPT
                        // =========================================================
                        Forms\Components\Select::make('type')
                            ->label('Jenis Materi')
                            ->options([
                                'video' => 'Video (Link Online)',
                                'document' => 'Dokumen (PDF Upload)',
                                'audio' => 'Audio (MP3/WAV Upload)',
                                'slide' => 'Slide Presentasi (PPT/PPTX Upload)', // <--- Opsi Slide Ditambahkan
                            ])
                            ->required()
                            ->reactive(), 

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
                            ->visibility('public') // <--- [BARU] Agar file bisa diunduh/dibaca santri
                            ->label(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => 'Upload Audio (MP3/WAV)',
                                'slide' => 'Upload Slide (PPT/PPTX)',
                                default => 'Upload File (PDF)'
                            })
                            ->acceptedFileTypes(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
                                'slide' => ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'], // MIME type PPT & PPTX
                                default => ['application/pdf']
                            })
                            ->directory(fn(Forms\Get $get) => match($get('type')) {
                                'audio' => 'materials/audio',
                                'slide' => 'materials/slides',
                                default => 'materials/documents'
                            })
                            ->downloadable()
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

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn(StudyMaterial $record) => \Illuminate\Support\Str::limit($record->description, 50)),

                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelompok (Grup)')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->default('Semua Santri'),

                // =========================================================
                // [MODIFIKASI] MENAMPILKAN BADGE SLIDE DI TABEL
                // =========================================================
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'video' => 'danger',
                        'document' => 'success',
                        'audio' => 'warning',
                        'slide' => 'info', // <--- Warna Biru/Info untuk Slide
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'video' => 'Video',
                        'document' => 'PDF',
                        'audio' => 'Audio',
                        'slide' => 'Slide PPT', // <--- Format Teks Slide
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
            // [BARU] FITUR BULK ACTION (Hapus Massal) UNTUK GURU
            // =========================================================
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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