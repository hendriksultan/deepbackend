<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use App\Models\TeacherProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Tugas Mandiri';
    protected static ?string $modelLabel = 'Tugas';
    protected static ?string $pluralModelLabel = 'Daftar Tugas';
    protected static ?string $navigationGroup = 'Manajemen Akademik'; // Disatukan dengan Materi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tugas')
                    ->schema([
                        // Admin harus memilih tugas ini milik guru siapa
                        Forms\Components\Select::make('teacher_profile_id')
                            ->label('Guru Pengampu')
                            ->options(TeacherProfile::with('user')->get()->pluck('user.name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(), // Agar dropdown grup di bawahnya bisa bereaksi

                        Forms\Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->required()
                            ->maxLength(255),

                        // Pilihan grup cerdas (Menyesuaikan guru yang dipilih di atas)
                        Forms\Components\Select::make('group_name')
                            ->label('Target Kelompok (Grup)')
                            ->options(function (Forms\Get $get) {
                                $teacherId = $get('teacher_profile_id');
                                if (!$teacherId) return [];

                                return \App\Models\Booking::where('teacher_profile_id', $teacherId)
                                    ->where('status', 'active')
                                    ->whereNotNull('group_name')
                                    ->distinct()
                                    ->pluck('group_name', 'group_name')
                                    ->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih kelas/halqoh...'),

                        Forms\Components\DateTimePicker::make('deadline')
                            ->label('Batas Waktu (Deadline)')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Instruksi Tugas')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('file_path')
                            ->label('Lampiran Soal (Opsional)')
                            ->directory('tasks/questions')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->downloadable()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Guru Pengampu')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelompok (Grup)')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Tenggat Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => $state->isPast() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('submissions_count')
                    ->counts('submissions')
                    ->label('Terkumpul')
                    ->badge()
                    ->color('info')
                    ->suffix(' Santri'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Kita pinjam tabel pengumpulan tugas milik Guru agar Admin juga bisa melihat isinya
            \App\Filament\Teacher\Resources\TaskResource\RelationManagers\SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}