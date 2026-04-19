<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-ticket';
    protected static string | \UnitEnum | null $navigationGroup = 'Toko';
    protected static ?string $navigationLabel = 'Voucher';
    protected static ?string $modelLabel = 'Voucher';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('Kode Voucher')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(50)
                        ->dehydrateStateUsing(fn ($state) => strtoupper($state)),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('type')
                        ->label('Tipe')
                        ->required()
                        ->options([
                            'percentage' => 'Persentase (%)',
                            'fixed' => 'Nominal Tetap (Rp)',
                        ])
                        ->live(),

                    Forms\Components\TextInput::make('value')
                        ->label('Nilai')
                        ->required()
                        ->numeric()
                        ->prefix(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('type') === 'percentage' ? '%' : 'Rp'),

                    Forms\Components\TextInput::make('min_purchase')
                        ->label('Minimum Belanja')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0),

                    Forms\Components\TextInput::make('max_discount')
                        ->label('Maks. Diskon')
                        ->numeric()
                        ->prefix('Rp')
                        ->visible(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('type') === 'percentage'),

                    Forms\Components\TextInput::make('quota')
                        ->label('Kuota (Opsional)')
                        ->numeric()
                        ->placeholder('Biarkan kosong jika tanpa kuota'),

                    Forms\Components\DatePicker::make('start_date')
                        ->label('Mulai Berlaku (Opsional)')
                        ->default(now()),

                    Forms\Components\DatePicker::make('end_date')
                        ->label('Berakhir Pada (Opsional)')
                        ->after('start_date'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->limit(30),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? '%' : 'Rp'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai'),

                Tables\Columns\TextColumn::make('used_count')
                    ->label('Terpakai')
                    ->formatStateUsing(fn ($state, Voucher $record) => "{$state}/{$record->quota}")
                    ->color(fn ($state, Voucher $record) => $state >= $record->quota ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->color(fn ($state) => now()->gt($state) ? 'danger' : 'success'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\ReplicateAction::make()
                    ->excludeAttributes(['code', 'used_count']),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
