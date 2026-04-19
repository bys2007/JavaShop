<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use \Filament\Forms;
use \Filament\Schemas\Schema;
use \Filament\Resources\Resource;
use \Filament\Tables;
use \Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-star';
    protected static string | \UnitEnum | null $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Ulasan';
    protected static ?string $modelLabel = 'Ulasan';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['product.images', 'user'])->orderBy('is_approved')->latest())
            ->columns([
                Tables\Columns\ImageColumn::make('product.images.image_url')
                    ->label('Produk')
                    ->circular()
                    ->limit(1),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->limit(20)
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state >= 3 ? 'warning' : 'danger')),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(40)
                    ->wrap(),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Approved'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Status Approval'),
            ])
            ->actions([
                \Filament\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Review $record) => !$record->is_approved)
                    ->action(fn (Review $record) => $record->update(['is_approved' => true])),
                \Filament\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Review $record) => $record->is_approved)
                    ->action(fn (Review $record) => $record->update(['is_approved' => false])),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkAction::make('approve_all')
                    ->label('Approve Semua')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['is_approved' => true]))
                    ->requiresConfirmation(),
                \Filament\Actions\BulkAction::make('reject_all')
                    ->label('Reject Semua')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn ($records) => $records->each->update(['is_approved' => false]))
                    ->requiresConfirmation(),
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
