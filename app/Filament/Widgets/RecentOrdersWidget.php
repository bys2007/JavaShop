<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'half';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->with('user')->latest())
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->weight('bold')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Menunggu',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Selesai',
                        'cancelled' => 'Batal',
                        default => $state,
                    }),
            ])
            ->paginated([5]);
    }
}
