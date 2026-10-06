<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;
    
    // Mengatur Icon dan Nama Menu di Dashboard Admin
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Manajemen Donasi';
    protected static ?string $navigationLabel = 'Program Donasi';
    protected static ?string $pluralModelLabel = 'Program Donasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Program')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Program / Campaign')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            // Otomatis membuat URL slug dari Judul
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Campaign::class, 'slug', ignoreRecord: true),

                        Forms\Components\FileUpload::make('image')
                            ->label('Banner Program')
                            ->image()
                            ->directory('campaigns')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Target & Batas Waktu')
                    ->schema([
                        Forms\Components\TextInput::make('target_amount')
                            ->label('Target Donasi (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('Batas Waktu (Opsional)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->inline(false),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Banner')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Program')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('target_amount')
                    ->label('Target')
                    ->money('IDR', locale: 'id') // Format Rupiah
                    ->sortable(),
                Tables\Columns\TextColumn::make('collected_amount')
                    ->label('Terkumpul')
                    ->money('IDR', locale: 'id') // Format Rupiah
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tenggat Waktu')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}