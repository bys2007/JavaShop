<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static string | \UnitEnum | null $navigationGroup = 'Toko';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?string $modelLabel = 'Kategori';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Kategori')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('image')
                ->label('URL Gambar')
                ->url(),

            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
