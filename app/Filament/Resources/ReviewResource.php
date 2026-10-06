<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Bagian FORM
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Nama'),
                Forms\Components\TextInput::make('role')->label('Status (Cth: Wali Santri)'),
                Forms\Components\Select::make('rating')
                    ->options([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5])
                    ->required(),
                Forms\Components\Textarea::make('content')->required()->label('Ulasan'),
                Forms\Components\Toggle::make('is_visible')->label('Tampilkan di Website?'),
            ]);
    }

   // Bagian TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rating')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('created_at')->date()->label('Tanggal'),
                Tables\Columns\ToggleColumn::make('is_visible')->label('Tampil'),
            ])
            ->defaultSort('created_at', 'desc')
            // [BARU] Menambahkan Actions untuk Edit dan Delete per baris
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // [BARU] Menambahkan Bulk Actions untuk hapus banyak data sekaligus
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
