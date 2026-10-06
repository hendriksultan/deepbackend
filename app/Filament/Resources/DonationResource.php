<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    // Mengatur Icon dan Nama Menu di Dashboard Admin
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Manajemen Donasi';
    protected static ?string $navigationLabel = 'Data Donatur';
    protected static ?string $pluralModelLabel = 'Data Donasi Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Donasi')
                    ->schema([
                        Forms\Components\Select::make('campaign_id')
                            ->relationship('campaign', 'title')
                            ->label('Program Donasi')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('donor_name')
                            ->label('Nama Donatur')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('donor_phone')
                            ->label('No. WhatsApp / HP')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal Donasi (Rp)')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                            
                        Forms\Components\Toggle::make('is_anonymous')
                            ->label('Sembunyikan Nama (Hamba Allah)')
                            ->inline(false),
                    ])->columns(2),

                Forms\Components\Section::make('Pembayaran & Validasi')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'manual' => 'Transfer Manual',
                                'tripay' => 'Otomatis (Tripay)',
                            ])
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Berhasil / Lunas',
                                'failed' => 'Gagal / Batal',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('reference')
                            ->label('Kode Referensi / Invoice')
                            ->required()
                            ->maxLength(255)
                            ->default(fn () => 'DQA-' . strtoupper(uniqid())),

                        Forms\Components\FileUpload::make('proof_of_payment')
                            ->label('Bukti Transfer (Jika Manual)')
                            ->image()
                            ->directory('donations/proofs')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('message')
                            ->label('Pesan / Doa dari Donatur')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('donor_name')
                    ->label('Nama Donatur')
                    ->searchable()
                    ->description(fn (Donation $record): string => $record->is_anonymous ? 'Hamba Allah' : ($record->donor_phone ?? '-')),

                Tables\Columns\TextColumn::make('campaign.title')
                    ->label('Program')
                    ->limit(20)
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id') // Format Rupiah
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tripay' => 'info',
                        'manual' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'paid' => 'Berhasil',
                        'failed' => 'Gagal',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->label('Filter Program'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Berhasil',
                        'failed' => 'Gagal',
                    ])
                    ->label('Filter Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tombol Lihat Bukti Transfer Cepat
                Tables\Actions\Action::make('lihat_bukti')
                    ->label('Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->url(fn (Donation $record): string => $record->proof_of_payment ? asset('storage/' . $record->proof_of_payment) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn (Donation $record): bool => $record->proof_of_payment !== null),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}