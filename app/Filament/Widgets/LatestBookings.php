<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookings extends BaseWidget
{
    protected static ?int $sort = 3; // Tampil di bawah chart
    protected int | string | array $columnSpan = 'full'; // Lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil 5 pendaftaran terbaru
                Booking::with(['user', 'teacherProfile.user'])->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Santri')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('teacherProfile.user.name')
                    ->label('Guru Tujuan'),
                Tables\Columns\TextColumn::make('method')
                    ->label('Metode')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}
