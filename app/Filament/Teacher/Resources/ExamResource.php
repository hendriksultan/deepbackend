<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\ExamResource\Pages;
use App\Filament\Teacher\Resources\ExamResource\RelationManagers\AttemptsRelationManager;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Bank Soal & Ujian';
    
    // ====================================================
    // [BARU] Mengubah teks singular agar tombol menjadi "Buat Soal Ujian"
    // ====================================================
    protected static ?string $modelLabel = 'Soal Ujian'; 
    
    protected static ?string $pluralModelLabel = 'Data Ujian';
    protected static ?string $navigationGroup = 'Ujian';

    // ====================================================
    // [PERBAIKAN KEAMANAN] Guru hanya bisa melihat/mengedit ujian miliknya sendiri
    // ====================================================
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('teacher_profile_id', Auth::user()->teacherProfile->id ?? 0);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // SECTION 1: EXAM INFORMATION
                Forms\Components\Section::make('Informasi Ujian')
                    ->description('Isi judul dan durasi pengerjaan.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Ujian / Kuis')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Durasi (Menit)')
                            ->numeric()
                            ->default(60)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktifkan Ujian?')
                            ->default(true),
                        Forms\Components\Hidden::make('teacher_profile_id')
                            ->default(fn() => Auth::user()->teacherProfile->id ?? null),
                    ])->columns(2),

                // SECTION 2: QUESTIONS INPUT (REPEATER)
                Forms\Components\Section::make('Daftar Pertanyaan')
                    ->schema([
                        Forms\Components\Repeater::make('questions')
                            ->relationship('questions')
                            ->label('Soal')

                            // --- FITUR DRAG & DROP & DUPLIKAT ---
                            ->reorderable('sort') // Menggunakan kolom 'sort' yang dibuat di migrasi
                            ->reorderableWithButtons() // Menambah tombol panah untuk aksesibilitas
                            ->cloneable() // Memungkinkan guru menduplikat soal dengan satu klik
                            // ------------------------------------

                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => strip_tags($state['question'] ?? null))
                            ->schema([
                                // 1. QUESTION TYPE
                                Forms\Components\Select::make('type')
                                    ->label('Jenis Soal')
                                    ->options([
                                        'multiple_choice' => 'Pilihan Ganda',
                                        'true_false' => 'Benar / Salah',
                                        'essay' => 'Esai',
                                    ])
                                    ->default('multiple_choice')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('options', null);
                                        $set('correct_answer', null);
                                        $set('ca_mc', null);
                                        $set('ca_tf', null);
                                        $set('ca_essay', null);
                                    })
                                    ->required(),

                                // 2. MEDIA (Image & Audio)
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->label('Gambar (Opsional)')
                                        ->image()
                                        ->directory('exam-images'),
                                    Forms\Components\FileUpload::make('audio')
                                        ->label('Audio (Opsional)')
                                        ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav'])
                                        ->directory('exam-audio'),
                                ]),

                                // 3. QUESTION TEXT
                                Forms\Components\Textarea::make('question')
                                    ->label('Pertanyaan')
                                    ->rows(2)
                                    ->required()
                                    ->columnSpanFull(),

                                // 4. OPTIONS (Only for Multiple Choice)
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('options.a')->label('Opsi A')->required(),
                                        Forms\Components\TextInput::make('options.b')->label('Opsi B')->required(),
                                        Forms\Components\TextInput::make('options.c')->label('Opsi C')->required(),
                                        Forms\Components\TextInput::make('options.d')->label('Opsi D')->required(),
                                    ])
                                    ->visible(fn(Get $get) => $get('type') === 'multiple_choice'),

                                // 5. CORRECT ANSWER LOGIC
                                Forms\Components\Hidden::make('correct_answer'),

                                Forms\Components\Grid::make(1)->schema([
                                    // Virtual Input: Multiple Choice
                                    Forms\Components\Select::make('ca_mc')
                                        ->label('Kunci Jawaban (PG)')
                                        ->options(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'])
                                        ->visible(fn(Get $get) => $get('type') === 'multiple_choice')
                                        ->required(fn(Get $get) => $get('type') === 'multiple_choice')
                                        ->live()
                                        ->dehydrated(false)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('correct_answer', $state))
                                        ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->correct_answer)),

                                    // Virtual Input: True/False
                                    Forms\Components\Select::make('ca_tf')
                                        ->label('Kunci Jawaban (Benar/Salah)')
                                        ->options(['true' => 'Benar', 'false' => 'Salah'])
                                        ->visible(fn(Get $get) => $get('type') === 'true_false')
                                        ->required(fn(Get $get) => $get('type') === 'true_false')
                                        ->live()
                                        ->dehydrated(false)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('correct_answer', $state))
                                        ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->correct_answer)),

                                    // Virtual Input: Essay
                                    Forms\Components\Textarea::make('ca_essay')
                                        ->label('Kata Kunci Jawaban (Essay)')
                                        ->visible(fn(Get $get) => $get('type') === 'essay')
                                        ->live()
                                        ->dehydrated(false)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('correct_answer', $state))
                                        ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->correct_answer)),
                                ]),

                                Forms\Components\TextInput::make('points')
                                    ->label('Bobot Nilai')
                                    ->numeric()
                                    ->default(10)
                                    ->required(),

                                Forms\Components\Textarea::make('explanation')
                                    ->label('Penjelasan / Pembahasan')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Soal'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttemptsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}