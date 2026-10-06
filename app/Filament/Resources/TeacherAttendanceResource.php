<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherAttendanceResource\Pages;
use App\Models\TeacherAttendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

// --- [IMPORT BARU] Library Export Excel ---
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
// ------------------------------------------

class TeacherAttendanceResource extends Resource
{
    protected static ?string $model = TeacherAttendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Manajemen Guru';
    protected static ?string $navigationLabel = 'Absensi Guru';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('teacher_profile_id')
                    ->label('Nama Guru')
                    ->relationship('teacherProfile', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now('Asia/Jakarta')),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TimePicker::make('clock_in')
                            ->label('Jam Masuk')
                            ->seconds(false),
                        Forms\Components\TimePicker::make('clock_out')
                            ->label('Jam Pulang')
                            ->seconds(false),
                    ]),

                Forms\Components\Select::make('status')
                    ->options([
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        'alpha' => 'Tanpa Keterangan',
                    ])
                    ->required()
                    ->default('present'),

                Forms\Components\FileUpload::make('proof_file')
                    ->label('Bukti / Surat')
                    ->directory('attendance-proofs')
                    ->visibility('public')
                    ->imagePreviewHeight('150')
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('note')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                // [BARU] Tombol Export menggunakan pxlrbt/filament-excel
                ExportAction::make()
                    ->label('Download Laporan (Excel)')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn() => 'Laporan_Absensi_Guru_' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('date')->heading('Tanggal'),
                                Column::make('teacherProfile.user.name')->heading('Nama Guru'),
                                Column::make('clock_in')->heading('Jam Masuk'),
                                Column::make('clock_out')->heading('Jam Pulang'),
                                Column::make('status')->heading('Status'),
                                Column::make('note')->heading('Catatan'),
                            ]),
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Nama Guru')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clock_in')
                    ->label('Masuk')
                    ->time('H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('clock_out')
                    ->label('Pulang')
                    ->time('H:i')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('proof_file')
                    ->label('Bukti')
                    ->formatStateUsing(fn($state) => empty($state) ? '-' : 'Lihat')
                    ->icon(fn($state) => empty($state) ? null : 'heroicon-m-document-text')
                    ->color(fn($state) => empty($state) ? 'gray' : 'info')
                    ->badge()
                    ->url(
                        fn(TeacherAttendance $record) =>
                        $record->proof_file ? Storage::url($record->proof_file) : null
                    )
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'present',
                        'warning' => 'sick',
                        'danger' => 'alpha',
                        'info' => 'permit',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permit' => 'Izin',
                        'alpha' => 'Alpha',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('teacher_profile_id')
                    ->label('Filter Guru')
                    ->relationship('teacherProfile.user', 'name'),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('date_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn(Builder $query, $date) => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn(Builder $query, $date) => $query->whereDate('date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeacherAttendances::route('/'),
            'create' => Pages\CreateTeacherAttendance::route('/create'),
            'edit' => Pages\EditTeacherAttendance::route('/{record}/edit'),
        ];
    }
}