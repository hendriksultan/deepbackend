<?php

namespace App\Filament\Teacher\Resources\TaskResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SubmissionsRelationManager extends RelationManager
{
    // Nama relasi yang ada di model Task.php
    protected static string $relationship = 'submissions';

    // Judul yang akan tampil di atas tabel
    protected static ?string $title = 'Daftar Pengumpulan Tugas (Santri)';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('score')
                    ->label('Nilai')
                    ->required()
                    ->numeric() // Agar guru hanya bisa input angka
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->label('Status Penilaian')
                    ->options([
                        'pending' => 'Menunggu Penilaian',
                        'graded' => 'Sudah Dinilai',
                    ])
                    ->default('graded')
                    ->required(),

                Forms\Components\Textarea::make('teacher_notes')
                    ->label('Catatan / Koreksi (Opsional)')
                    ->placeholder('Misal: Bagus sekali, pertahankan!')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ====================================================================
            // 🛑 [UPDATE FINAL - SANGAT PENTING] 🛑
            // Matikan aksi klik baris default agar tidak bentrok dengan download/audio
            // Guru sekarang HARUS mengklik tombol "Beri Nilai" secara eksplisit.
            // ====================================================================
            ->recordAction(null)
            ->recordUrl(null)
            // ====================================================================

            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Santri')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Kumpul')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                // Logika File / Audio Player Tetap Aman
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Jawaban Santri')
                    ->html()
                    ->wrap()
                    ->formatStateUsing(function (string $state) {
                        $url = asset('storage/' . $state);
                        
                        // Ambil ekstensi file
                        $extension = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        $audioExtensions = ['mp3', 'wav', 'ogg', 'm4a', 'aac'];

                        // JIKA FILE ADALAH AUDIO
                        if (in_array($extension, $audioExtensions)) {
                            return '
                                <div style="min-width: 250px; padding: 4px 0;">
                                    <audio controls preload="metadata" onclick="event.stopPropagation()" style="height: 40px; width: 100%; border-radius: 8px;">
                                        <source src="' . $url . '" type="audio/' . ($extension === 'mp3' ? 'mpeg' : $extension) . '">
                                        Browser Anda tidak mendukung elemen audio.
                                    </audio>
                                    <div style="text-align: right; margin-top: 4px;">
                                        <a href="' . $url . '" download target="_blank" onclick="event.stopPropagation()" style="font-size: 11px; color: #10b981; font-weight: bold; text-decoration: underline;">Unduh Backup</a>
                                    </div>
                                </div>
                            ';
                        }

                        // JIKA FILE BUKAN AUDIO (PDF, Word, Gambar)
                        return '
                            <a href="' . $url . '" download target="_blank" onclick="event.stopPropagation()" style="display: inline-flex; align-items: center; gap: 6px; color: #10b981; font-weight: bold; background: rgba(16, 185, 129, 0.1); padding: 6px 12px; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh File
                            </a>
                        ';
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'graded' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'graded' => 'Dinilai',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->weight('bold')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Dikosongkan karena Guru tidak membuat submission, melainkan Santri
            ])
            ->actions([
                // Tombol untuk memasukkan nilai
                Tables\Actions\EditAction::make()
                    ->label('Beri Nilai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->modalHeading('Nilai Tugas Santri')
                    ->modalWidth('md'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}