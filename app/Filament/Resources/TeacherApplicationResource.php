<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherApplicationResource\Pages;
use App\Models\TeacherApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeacherApplicationResource extends Resource
{
    protected static ?string $model = TeacherApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $navigationLabel = 'Lamaran Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No WhatsApp')
                            ->tel()
                            ->required(),
                        Forms\Components\DatePicker::make('dob')
                            ->label('Tanggal Lahir')
                            ->required(),
                        Forms\Components\TextInput::make('pob')
                            ->label('Tempat Lahir')
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])->required(),
                        Forms\Components\Select::make('marital_status')
                            ->label('Status')
                            ->options([
                                'single' => 'Belum Menikah',
                                'married' => 'Menikah',
                            ])->required(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Domisili')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Pendidikan & Kompetensi')
                    ->schema([
                        Forms\Components\Select::make('last_education')
                            ->label('Pendidikan Terakhir')
                            ->options([
                                'SMA/MA' => 'SMA/MA',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'Ma\'had' => 'Lulusan Pesantren',
                            ])->required(),
                        Forms\Components\TextInput::make('institution')
                            ->label('Institusi/Kampus')
                            ->required(),
                        Forms\Components\TextInput::make('memorization_juz')
                            ->label('Jumlah Hafalan (Juz)')
                            ->required(),
                        Forms\Components\Select::make('arabic_skill')
                            ->label('Bahasa Arab')
                            ->options([
                                'Pemula' => 'Pemula',
                                'Pasif' => 'Pasif',
                                'Aktif' => 'Aktif',
                            ])->required(),
                        Forms\Components\Toggle::make('has_sanad')
                            ->label('Memiliki Sanad?')
                            ->inline(false),
                        Forms\Components\Textarea::make('sanad_details')
                            ->label('Detail Sanad')
                            ->placeholder('Isi jika memiliki sanad'),
                    ])->columns(2),

                Forms\Components\Section::make('Berkas Lamaran')
                    ->schema([
                        // =========================================================
                        // [PERBAIKAN] Menambahkan disk, openable, dan downloadable
                        // =========================================================
                        Forms\Components\FileUpload::make('photo_path')
                            ->label('Pas Foto')
                            ->image()
                            ->disk('public') // <--- Agar gambar muncul dari folder public
                            ->directory('applicants/photo')
                            ->openable()     // <--- Bisa dibuka
                            ->downloadable() // <--- Bisa didownload
                            ->required(),
                        
                        Forms\Components\FileUpload::make('cv_path')
                            ->label('CV (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public') 
                            ->directory('applicants/cv')
                            ->openable()     
                            ->downloadable() 
                            ->required(),
                        
                        Forms\Components\FileUpload::make('certificate_path')
                            ->label('Sertifikat/Ijazah')
                            ->disk('public') 
                            ->directory('applicants/cert')
                            ->openable()     
                            ->downloadable(),
                        // =========================================================
                    ])->columns(3),

                Forms\Components\Section::make('Status Lamaran')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Menunggu Review',
                                'interview' => 'Wawancara',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('pending')
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
                    ->label('Tgl Daftar')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo_path')
                    ->circular()
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('memorization_juz')
                    ->label('Hafalan')
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('has_sanad')
                    ->boolean()
                    ->label('Sanad'),
                Tables\Columns\TextColumn::make('last_education')
                    ->label('Pendidikan'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'interview' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(), 
                Tables\Actions\EditAction::make(), 
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('download_cv')
                    ->label('CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => asset('storage/' . $record->cv_path))
                    ->openUrlInNewTab()
                    ->color('info'),
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
            'index' => Pages\ListTeacherApplications::route('/'),
            'create' => Pages\CreateTeacherApplication::route('/create'),
            'edit' => Pages\EditTeacherApplication::route('/{record}/edit'),
        ];
    }
}