<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';
    protected static string | \UnitEnum | null $navigationGroup = 'Toko';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $modelLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Produk';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Dasar')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Produk')
                        ->required()
                        ->maxLength(200)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(200),

                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->options(Category::active()->pluck('name', 'id'))
                        ->required()
                        ->searchable(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),

                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi')
                        ->toolbarButtons(['bold', 'italic', 'bulletList', 'link'])
                        ->columnSpanFull(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Foto Produk')
                ->schema([
                    Forms\Components\Repeater::make('images')
                        ->relationship()
                        ->schema([
                            Forms\Components\ToggleButtons::make('upload_type')
                                ->label('Metode Gambar')
                                ->options([
                                    'upload' => 'Unggah File Lokal',
                                    'url' => 'Tautan URL Bawaan',
                                ])
                                ->inline()
                                ->default('upload')
                                ->live()
                                ->afterStateHydrated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) {
                                    $val = $get('image_url');
                                    if ($val && str_starts_with($val, 'http')) {
                                        $set('upload_type', 'url');
                                    } else {
                                        $set('upload_type', 'upload');
                                    }
                                })
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('local_file')
                                ->label('Pilih Gambar / Unggah')
                                ->image()
                                ->directory('products')
                                ->columnSpanFull()
                                ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('upload_type') !== 'upload')
                                ->required(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('upload_type') === 'upload')
                                ->afterStateHydrated(function (\Filament\Schemas\Components\Utilities\Set $set, \Filament\Schemas\Components\Utilities\Get $get) {
                                    $val = $get('image_url');
                                    if ($val && !str_starts_with($val, 'http')) {
                                        $set('local_file', $val);
                                    }
                                }),

                            Forms\Components\TextInput::make('image_url')
                                ->label('URL Gambar')
                                ->url()
                                ->columnSpanFull()
                                ->hidden(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('upload_type') !== 'url')
                                ->required(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('upload_type') === 'url'),
                                
                            Forms\Components\Toggle::make('is_primary')
                                ->label('Foto Utama')
                                ->default(false),
                            Forms\Components\TextInput::make('sort_order')
                                ->label('Urutan')
                                ->numeric()
                                ->default(0),
                        ])
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                            if (($data['upload_type'] ?? 'upload') === 'upload') {
                                $data['image_url'] = $data['local_file'] ?? null;
                            }
                            unset($data['upload_type'], $data['local_file']);
                            return $data;
                        })
                        ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                            if (($data['upload_type'] ?? 'upload') === 'upload') {
                                $data['image_url'] = $data['local_file'] ?? null;
                            }
                            unset($data['upload_type'], $data['local_file']);
                            return $data;
                        })
                        ->columns(3)
                        ->defaultItems(1)
                        ->addActionLabel('+ Tambah Foto')
                        ->collapsible(),
                ]),

            \Filament\Schemas\Components\Section::make('Varian Produk')
                ->schema([
                    Forms\Components\Repeater::make('variants')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('size')
                                ->label('Ukuran')
                                ->required()
                                ->placeholder('100g'),

                            Forms\Components\Select::make('grind_type')
                                ->label('Gilingan')
                                ->required()
                                ->options([
                                    'Biji Utuh' => 'Biji Utuh',
                                    'Coarse' => 'Coarse',
                                    'Medium' => 'Medium',
                                    'Fine' => 'Fine',
                                    'Extra Fine' => 'Extra Fine',
                                ]),

                            Forms\Components\TextInput::make('price')
                                ->label('Harga')
                                ->required()
                                ->numeric()
                                ->prefix('Rp'),

                            Forms\Components\TextInput::make('stock')
                                ->label('Stok')
                                ->required()
                                ->numeric()
                                ->default(0),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->unique(ignoreRecord: true)
                                ->maxLength(100)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->defaultItems(1)
                        ->addActionLabel('+ Tambah Varian')
                        ->collapsible(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.image_url')
                    ->label('Foto')
                    ->circular()
                    ->limit(1)
                    ->defaultImageUrl('https://placehold.co/40x40/F0E8D8/6B4C35?text=P'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('variants_sum_stock')
                    ->label('Stok Total')
                    ->sum('variants', 'stock')
                    ->sortable()
                    ->color(fn ($state): string => match (true) {
                        $state < 10 => 'danger',
                        $state < 30 => 'warning',
                        default => 'success',
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('variants_min_price')
                    ->label('Harga Dari')
                    ->min('variants', 'price')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(Category::pluck('name', 'id')),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                \Filament\Actions\ReplicateAction::make()
                    ->excludeAttributes(['slug', 'variants_sum_stock', 'variants_min_price'])
                    ->beforeReplicaSaved(function (\Illuminate\Database\Eloquent\Model $replica): void {
                        $replica->name = $replica->name . ' (Copy)';
                        $replica->slug = \Illuminate\Support\Str::slug($replica->name) . '-' . time();
                    }),
            ])
            ->bulkActions([
                \Filament\Actions\BulkAction::make('activate')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['is_active' => true]))
                    ->requiresConfirmation(),
                \Filament\Actions\BulkAction::make('deactivate')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn ($records) => $records->each->update(['is_active' => false]))
                    ->requiresConfirmation(),
                \Filament\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
