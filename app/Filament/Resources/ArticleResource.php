<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Blog & Artikel';
    protected static ?string $pluralModelLabel = 'Data Artikel';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Artikel')
                    ->description('Silakan tulis artikel dengan format Heading 2 atau Heading 3 untuk sub-bab agar Daftar Isi muncul otomatis.')
                    ->schema([
                        // Judul Artikel
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Artikel')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true) // Aktifkan live update saat kursor pindah
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        // Slug (URL Otomatis)
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->disabled()
                            ->dehydrated() // Pastikan data tetap tersimpan meski di-disable
                            ->required()
                            ->unique(Article::class, 'slug', ignoreRecord: true),

                        // Thumbnail / Gambar Cover
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Gambar Cover (Thumbnail)')
                            ->image()
                            ->directory('article-thumbnails')
                            ->imageEditor()
                            ->columnSpanFull(),

                        // Isi Artikel (Rich Text Editor)
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Artikel / Kisah')
                            ->required()
                            ->fileAttachmentsDirectory('article-images')
                            ->columnSpanFull()
                            // [TAMBAHAN] Toolbar yang lebih lengkap untuk mempermudah formatting
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2', // Penting untuk Daftar Isi
                                'h3', // Penting untuk Daftar Isi
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ]),
                    ])->columns(2)->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Pengaturan Publikasi')
                    ->schema([
                        // Dropdown Kategori
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label('Kategori')
                            ->searchable()
                            ->preload()
                            ->required()
                            // Fitur tambah kategori langsung dari halaman tulis artikel
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Kategori Baru')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        // Penulis
                        Forms\Components\TextInput::make('author')
                            ->label('Penulis')
                            ->default('Admin')
                            ->required(),

                        // Status Publish
                        Forms\Components\Toggle::make('is_published')
                            ->label('Terbitkan Artikel?')
                            ->default(true)
                            ->helperText('Matikan jika artikel ini masih berupa Draft.'),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Cover')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),

                // Kolom Kategori di tabel
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Status Publish'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter Kategori di tabel
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Filter Kategori')
                    ->searchable()
                    ->preload(),
            ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
