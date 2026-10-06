<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\TaskResource\RelationManagers;
use App\Filament\Teacher\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Tugas Mandiri';
    protected static ?string $modelLabel = 'Tugas';
    protected static ?string $pluralModelLabel = 'Daftar Tugas';
    protected static ?string $navigationGroup = 'Manajemen Kelas';

    // =========================================================================
    // [KEAMANAN] GURU HANYA MELIHAT TUGASNYA SENDIRI
    // =========================================================================
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
                Forms\Components\Section::make('Informasi Tugas')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->required()
                            ->maxLength(255),

                        // =========================================================
                        // [BARU] Dropdown Pilihan Kelompok Otomatis
                        // =========================================================
                        Forms\Components\Select::make('group_name')
                            ->label('Pilih Kelompok (Grup)')
                            ->options(function () {
                                // Ambil ID profil guru yang sedang login
                                $teacherId = Auth::user()->teacherProfile->id ?? null;
                                if (!$teacherId) return [];

                                // Cari daftar grup unik yang diajar oleh guru ini dari tabel bookings
                                return \App\Models\Booking::where('teacher_profile_id', $teacherId)
                                    ->where('status', 'active')
                                    ->whereNotNull('group_name')
                                    ->distinct()
                                    ->pluck('group_name', 'group_name')
                                    ->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih kelas/halqoh untuk tugas ini...'),

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

                        // Otomatis isi ID Guru pembuat tugas
                        Forms\Components\Hidden::make('teacher_profile_id')
                            ->default(fn() => Auth::user()->teacherProfile->id ?? null),
                    ])->columns(2), // Layout 2 kolom (Kiri: Judul & Grup, Kanan: Deadline)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->weight('bold'),

                // =========================================================
                // [BARU] Menampilkan Nama Grup di Tabel Daftar Tugas
                // =========================================================
                Tables\Columns\TextColumn::make('group_name')
                    ->label('Kelompok (Grup)')
                    ->searchable()
                    ->badge()
                    ->color('primary'), // Warna biru elegan

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Tenggat Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => $state->isPast() ? 'danger' : 'success'),

                // Menghitung jumlah santri yang sudah mengumpulkan
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Menambahkan awalan "TaskResource\" agar jalurnya tepat sasaran
            TaskResource\RelationManagers\SubmissionsRelationManager::class,
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