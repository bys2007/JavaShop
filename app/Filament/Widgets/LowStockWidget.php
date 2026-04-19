<?php

namespace App\Filament\Widgets;

use App\Models\ProductVariant;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockWidget extends BaseWidget
{
    protected static ?string $heading = 'Peringatan Stok Rendah';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'half';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProductVariant::query()
                    ->with('product')
            )
            ->defaultSort('stock', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Ukuran'),
                Tables\Columns\TextColumn::make('grind_type')
                    ->label('Gilingan'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state) => $state <= 0 ? 'danger' : 'warning')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('stock_threshold')
                    ->form([
                        TextInput::make('threshold')
                            ->label('Batas Maksimal Stok')
                            ->numeric()
                            ->default(10),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $threshold = $data['threshold'] ?? 10;
                        return $query->where('stock', '<=', (int) $threshold);
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return 'Stok <= ' . ($data['threshold'] ?? 10);
                    })
            ])
            ->paginated([5, 10, 25]);
    }
}
