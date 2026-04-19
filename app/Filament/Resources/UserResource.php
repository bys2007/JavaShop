<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static string | \UnitEnum | null $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Info Pengguna')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->disabled(),

                    Forms\Components\TextInput::make('phone')
                        ->label('Telepon'),

                    Forms\Components\Select::make('role')
                        ->label('Peran')
                        ->options([
                            'customer' => 'Customer',
                            'admin' => 'Admin',
                        ])
                        ->required(),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Bergabung')
                        ->content(fn (User $record) => $record->created_at->format('d M Y')),

                    Forms\Components\Placeholder::make('orders_count')
                        ->label('Total Pesanan')
                        ->content(fn (User $record) => $record->orders()->count()),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('')
                    ->circular()
                    ->size(36),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'admin' ? 'danger' : 'info'),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Pesanan')
                    ->counts('orders')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
